<?php

namespace App\Repositories\Settings\Item;


use App\Http\Resources\ArrayCollection;
use App\Models\Invoice;
use App\Models\Product;

class ProductRepository
{
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }
    public function paginate(Array $datas) {
        $filters = $datas['filters'];
        $product = $filters['product'];

        $filteredProducts = $this->model::whereActive(true);


        if (!empty($product)) {
            $filteredProducts = $filteredProducts
                ->where('alias', 'LIKE', '%' . $product . '%')
                ->orWhere('name', 'LIKE', '%' . $product . '%');
        }

        $filteredProducts = $filteredProducts
            ->with('quantities')
            ->orderBy('name', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(15);
        return ArrayCollection::collection($filteredProducts);
    }

    public function search(Array $request)
    {
        $query = $request['query'];

        $products = Product::whereActive(true)
            ->where('alias', 'LIKE', '%' . $query . '%')
            ->orWhere('name', 'LIKE', '%' . $query . '%')
            ->with('quantities')
            ->distinct('id')
            ->orderBy('name', 'asc')
            ->limit(5)
            ->get();
        if (!isset($products)) {
            $products = Product::whereActive(true)
                ->with('quantities')
                ->orderBy('name', 'asc')
                ->take(5)
                ->get();
        }
        return ArrayCollection::collection($products);
    }
}
