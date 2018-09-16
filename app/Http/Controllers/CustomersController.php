<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::with('company')->
        withLastInteractionType()->
        whereFilters($request->only(['search', 'filter']))->
        orderByField($request->get('orderBy', 'name'), $request->get('order', 'asc'))->
        paginate();

        return view('customers', ['customers' => $customers]);
    }

    public function edit(Customer $customer)
    {
        return view('customer', ['customer' => $customer]);
    }

    public function add(Request $request)
    {
    	return view('addcustomer');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name'=>'required|max:255',
            'last_name'=>'required|max:255',
            'birth_date'=>'required|date'
        ]);
        $customer = new Customer;
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->birth_date = $request->birth_date;
        $customer->save();
        $customers = Customer::paginate();

        return view('customers', ['customers' => $customers]);
    }
}
