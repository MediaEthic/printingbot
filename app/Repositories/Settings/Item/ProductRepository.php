<?php

namespace App\Repositories\Settings\Item;


use App\Http\Resources\ArrayCollection;
use App\Models\Invoice;
use App\Models\Product;

class ProductRepository
{
    public function index($datas = null) {
        return $datas;
        $products = Product::whereActive(true)
            ->orderBy('name', 'asc');

        if ($pagination) {
            $products = $products->paginate($pagination);
        } else {
            $products = $products->get();
        }

        return ArrayCollection::collection($products);


//        $filters = $datas['filters'];
//        $invoiceNo = $filters['invoiceNumber'];
//        $invoiceDate = $filters['invoiceDate'];
//        $dueDate = $filters['dueDate'];
//        $customer = $filters['customer'];
//        $status = $filters['status'];
//        $exported = $filters['exported'];
//        $deliveryNumber = $filters['deliveryNumber'];
//
//        $allInvoices = Invoice::select('id', 'created_at', 'third_id', 'total', 'invoice_status');
//
//        if (!empty($invoiceNo)) {
//            $allInvoices = $allInvoices->where('id', $invoiceNo);
//        }
//
//        $allInvoices = $allInvoices->with('third')
//            ->with('lines') // TODO : to remove after
//            ->orderBy('created_at', 'desc')
//            ->paginate(15);
//        return ArrayCollection::collection($allInvoices);
    }

    public function getById($id)
    {
        return Invoice::findOrFail($id);
    }

    public function search(Array $request)
    {
        $query = $request['query'];

        return Product::whereActive(true)
            ->where('alias', 'LIKE', '%' . $query . '%')
            ->orWhere('name', 'LIKE', '%' . $query . '%')
            ->with('quantities')
            ->orderBy('name', 'asc')
            ->take(5)
            ->get();
    }
}
