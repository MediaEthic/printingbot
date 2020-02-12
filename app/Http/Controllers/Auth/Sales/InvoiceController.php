<?php

namespace App\Http\Controllers\Auth\Sales;

use App\Http\Resources\ArrayCollection;
use App\Models\Invoice;
use App\Repositories\Sales\InvoiceRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * InvoiceRepository
     *
     * @var App\Repositories\InvoiceRepository
     */
    protected $repository;


    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct(InvoiceRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->repository->paginate($request->all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->repository->store($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        return new ArrayCollection($invoice);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->repository->getById($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        return $this->repository->update($invoice, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filtered(Request $request)
    {
        return $this->repository->paginate($request->all());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editStatus(Request $request)
    {
        return $this->repository->editStatus($request->all());
    }

    public function generatePDF($invoices)
    {
        return $this->repository->generatePDF($invoices);
    }

    public function searchCustomers(Request $request)
    {
        return $this->repository->searchCustomers($request->all());
    }
}
