<?php

namespace App\Repositories\Sales;


use App\Http\Resources\ArrayCollection;
use App\Models\Invoice;
use App\Models\InvoiceLine;

class InvoiceLineRepository
{
    protected $model;

    public function __construct(InvoiceLine $model)
    {
        $this->model = $model;
    }
    public function index(Array $datas) {

    }

    public function searchCustomers(Array $request)
    {

    }

    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function destroy($invoice, $line)
    {
        $this->getById($line)->delete();
        return $this->model->where('invoice_id', $invoice)
                ->with(['product' => function($query) {
                    $query->with('quantities');
                }
            ])->get();
    }
}
