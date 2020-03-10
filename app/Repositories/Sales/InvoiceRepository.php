<?php

namespace App\Repositories\Sales;


use App\Http\Resources\ArrayCollection;
use App\Models\Invoice;
use App\Models\InvoiceLine;

class InvoiceRepository
{
    protected $model;

    public function __construct(Invoice $model)
    {
        $this->model = $model;
    }

    public function paginate(Array $datas) {
        $filters = $datas['filters'];
        $invoiceNo = $filters['invoiceNumber'];
        $invoiceDate = $filters['invoiceDate'];
        $dueDate = $filters['dueDate'];
        $customer = $filters['customer'];
        $status = $filters['status'];
        $exported = $filters['exported'];
        $deliveryNumber = $filters['deliveryNumber'];
        $orderNumber = $filters['orderNumber'];

        $filteredInvoices = Invoice::select('id', 'invoice_no', 'invoice_date', 'third_alias', 'third_name', 'total', 'invoice_status');

        if (!empty($invoiceNo)) {
            $filteredInvoices = $filteredInvoices->where('invoice_no', $invoiceNo);
        }
        if (!empty($invoiceDate)) {
            $from = $invoiceDate[0];
            $to = $invoiceDate[1];
            $filteredInvoices = $filteredInvoices->whereBetween('invoice_date', [$from, $to]);
        }
        if (!empty($dueDate)) {
            $filteredInvoices = $filteredInvoices->where('due_date', $dueDate);
        }
        if (!empty($customer)) {
            $filteredInvoices = $filteredInvoices->where('third_name', $customer)
            ->orWhere('third_alias', $customer);
        }
        if (!empty($status)) {
            $filteredInvoices = $filteredInvoices->where('invoice_status', $status);
        }
        if (!empty($exported)) {
            if ($exported === "true") {
                $filteredInvoices = $filteredInvoices->whereNotNull('sales_id');
            } else {
                $filteredInvoices = $filteredInvoices->whereNull('sales_id');
            }
        }
        if (!empty($deliveryNumber)) {
            $filteredInvoices = $filteredInvoices->whereHas('lines', function($query) use ($deliveryNumber) {
                $query->where('delivery_line_id', $deliveryNumber);
            });
        }
        if (!empty($orderNumber)) {
            $filteredInvoices = $filteredInvoices->whereHas('lines', function($query) use ($orderNumber) {
                $query->where('order_line_id', $orderNumber);
            });
        }

        $filteredInvoices = $filteredInvoices
            ->orderBy('invoice_date', 'desc')
            ->orderBy('invoice_no', 'desc')
            ->paginate(15);
        return ArrayCollection::collection($filteredInvoices);
    }

    public function searchCustomers(Array $request)
    {
        $query = $request['query'];

        $invoices = Invoice::select('third_alias', 'third_name')
            ->where('third_alias', 'LIKE', '%' . $query . '%')
            ->orWhere('third_name', 'LIKE', '%' . $query . '%')
            ->distinct('id')
            ->orderBy('third_name', 'asc')
            ->take(5)
            ->get();

        $map = $invoices->map(function($items) {
            $data['name'] = $items->third_name;
            $data['alias'] = $items->third_alias;
            return $data;
        });

        return $map;
    }

    public function getById($id)
    {
        $invoice = Invoice::with(['lines' => function($query) {
                    $query->with(['product' => function($query) {
                        $query->with('quantities');
                    }]);
                }])->with('establishment')->with('salesperson')->with('third') // things needed for pdf
            ->findOrFail($id);

        return new ArrayCollection($invoice);
    }

    public function store(Array $datas)
    {
        $datasInvoice = $datas['invoice'];

        $getInvoiceNo = $this->getInvoiceNo($datasInvoice['invoice_date']);
        $datasInvoice['invoice_no'] = $getInvoiceNo;

        $invoice = $this->model->create($datasInvoice);

        $datasLines = $datas['lines'];
        foreach ($datasLines as $line) {
            $line['invoice_id'] = $invoice->id;
            InvoiceLine::create($line);
        }

        return $this->getById($invoice->id);
    }

    public function update($model, Array $datas)
    {
        $datasInvoice = $datas['invoice'];
        $model->update($datasInvoice);

        $datasLines = $datas['lines'];
        foreach ($datasLines as $line) {
            if (!empty($line['id'])) {
                $modelLine = InvoiceLine::findOrfail($line['id']);
                $modelLine->update($line);
            } else {
                $line['invoice_id'] = $model->id;
                InvoiceLine::create($line);
            }
        }

        return $this->getById($model->id);
    }

    public function editStatus(Array $datas)
    {
        $invoices = $datas['invoices'];

        foreach ($invoices as $id) {
            $modelInvoice = Invoice::findOrFail($id);
            if ($modelInvoice->invoice_status === "draft") {
                $modelInvoice->invoice_status = "edited";
                $modelInvoice->save();
            }
        }

        return $this->paginate($datas);
    }

    public function generatePDF($invoicesId)
    {
        $invoices = array();

        foreach (json_decode($invoicesId) as $id) {
            $invoices[] = $this->getById($id);
        }

        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('pdf.invoice', compact('invoices'));
        $numberInvoices = count($invoices);
        if ($numberInvoices === 1) {
            $name = "I#" . $invoices[0]['invoice_no'] . ".pdf";
        } else {
            $name = "invoices(" . $numberInvoices . ").pdf";
        }

        return $pdf->stream($name);
    }

    public function replicate($model, Array $datas)
    {
        $existingInvoice = $this->model->findOrFail($model->id);
        $existingInvoice->load('lines');
        $newInvoice = $existingInvoice->replicate();

        $newInvoice->invoice_date = date('Y-m-d');

        $getInvoiceNo = $this->getInvoiceNo($newInvoice->invoice_date);
        $newInvoice->invoice_no = $getInvoiceNo;

        $newInvoice->invoice_status = "draft";
        $newInvoice->sales_id = null;

        $newInvoice->save();

        foreach($existingInvoice->getRelations() as $relation => $items) {
            foreach($items as $item){
                unset($item->id);
                $item->invoice_id = $newInvoice->id;
                $newInvoice->{$relation}()->create($item->toArray());
            }
        }
        return $newInvoice->id;
    }

    public function getInvoiceNo($date)
    {
        $lastInvoiceInserted = Invoice::latest()->first();
        if ($lastInvoiceInserted) {
            $invoiceID = $lastInvoiceInserted->id + 1;
        } else {
            $invoiceID = 1;
        }

        return date("y/m/", strtotime($date)) . str_pad($invoiceID, 5, 0, STR_PAD_LEFT);
    }
}
