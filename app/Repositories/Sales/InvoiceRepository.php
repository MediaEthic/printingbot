<?php

namespace App\Repositories\Sales;


use App\Http\Resources\ArrayCollection;
use App\Models\Invoice;

class InvoiceRepository
{
    public function index(Array $datas) {
        $filters = $datas['filters'];
        $invoiceNo = $filters['invoiceNumber'];
        $invoiceDate = $filters['invoiceDate'];
        $dueDate = $filters['dueDate'];
        $customer = $filters['customer'];
        $status = $filters['status'];
        $exported = $filters['exported'];
        $deliveryNumber = $filters['deliveryNumber'];

        $allInvoices = Invoice::select('id', 'created_at', 'third_id', 'total', 'invoice_status');

        if (!empty($invoiceNo)) {
            $allInvoices = $allInvoices->where('id', $invoiceNo);
        }

        $allInvoices = $allInvoices->with('third')
            ->with('lines') // TODO : to remove after
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return ArrayCollection::collection($allInvoices);
    }

    public function getById($id)
    {
        return Invoice::findOrFail($id);
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
        $name = "invoices(" . count($invoices) . ").pdf";
        return $pdf->stream($name);
    }

    public function searchCustomers(Array $datas)
    {
        return $datas;
    }
}
