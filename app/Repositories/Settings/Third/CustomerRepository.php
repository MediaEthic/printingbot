<?php

namespace App\Repositories\Settings\Third;


use App\Http\Resources\ArrayCollection;
use App\Models\Contact;
use App\Models\Invoice;
use App\Models\Third;

class CustomerRepository
{
    protected $model;

    public function __construct(Third $model)
    {
        $this->model = $model;
    }

    public function paginate(Array $datas) {
        $filters = $datas['filters'];
        $customer = $filters['customer'];
        $contact = $filters['contact'];
        $postcode = $filters['postcode'];
        $salesperson = $filters['salesperson'];

        $filteredCustomers = Third::where('type', 'customer')
            ->with(['contacts' => function($query) {
                $query->whereDefault(true);
            }])
            ->whereActive(true);


        if (!empty($customer)) {
            $filteredCustomers = $filteredCustomers
                ->where('alias', 'LIKE', '%' . $customer . '%')
                ->orWhere('name', 'LIKE', '%' . $customer . '%');
        }
        if (!empty($contact)) {
            $filteredCustomers = $filteredCustomers->whereHas('contacts', function($query) use ($contact) {
                $query->where('name', 'LIKE', '%' . $contact . '%')
                ->orWhere('lastname', 'LIKE', '%' . $contact . '%');
            });
        }
        if (!empty($postcode)) {
            $filteredCustomers = $filteredCustomers->whereHas('addresses', function($query) use ($postcode) {
                $query->where('postcode', 'LIKE', $postcode);
            });
        }
        if (!empty($salesperson)) {
            $filteredCustomers = $filteredCustomers->whereHas('salesperson', function($query) use ($salesperson) {
                $query->where('id', $salesperson);
            });
        }

        $filteredCustomers = $filteredCustomers
            ->orderBy('name', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(15);
        return ArrayCollection::collection($filteredCustomers);

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

    public function searchContacts(Array $request)
    {
        $query = $request['query'];

        return ArrayCollection::collection(Contact::whereActive(true)
            ->where('name', 'LIKE', '%' . $query . '%')
            ->orWhere('lastname', 'LIKE', '%' . $query . '%')
            ->distinct('id')
            ->orderBy('lastname', 'asc')
            ->orderBy('name', 'asc')
            ->take(5)
            ->get());
    }
}
