<?php

namespace App\Repositories\Settings\Third;


use App\Http\Resources\ArrayCollection;
use App\Models\Invoice;
use App\Models\Third;

class CustomerRepository
{
    protected $model;

    public function __construct(Third $model)
    {
        $this->model = $model;
    }

    public function index($datas = null) {

    }

    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function search(Array $request)
    {
        $query = $request['query'];

        return ArrayCollection::collection($this->model->whereActive(true)
            ->where('type', 'customer')
            ->where('alias', 'LIKE', '%' . $query . '%')
            ->orWhere('name', 'LIKE', '%' . $query . '%')
            ->distinct('id')
            ->orderBy('name', 'asc')
            ->take(5)
            ->get());
    }
}
