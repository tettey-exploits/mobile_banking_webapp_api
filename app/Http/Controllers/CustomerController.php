<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\ResponseResource;
use App\Models\Balance;
use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ResponseResource
    {
        $customers = Customer::with("balance")->get();

        return ResponseResource::make($customers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request): ResponseResource
    {

        $new_customer_details = $request->merge([
            'password' => Hash::make($request->password)
        ]);

        $new_customer = Customer::create($new_customer_details->all());

        // Create an associated balance record
        Balance::insert([
            "customer_id"=>$new_customer->id,
            "balance"=>0.00,
            "created_at"=>now(),
            "updated_at"=>now()
        ]);

        return ResponseResource::make($new_customer);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer): ResponseResource
    {
        $cus_data = Customer::with("balance")->where("id", $customer->id)->first();
        return ResponseResource::make($cus_data);//->with("balance")-);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
        return [
            "request"=>$request,
            "customer"=>$customer
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer): ResponseResource
    {
        try {
            if($customer->balance->delete()){
                $customer->delete();
            }
            $success = true;
            $message = "Customer records successfully deleted";
        }catch (Exception $e){
            $success = false;
            $message = $e->getMessage();
        }


        return ResponseResource::make([
            "success" => $success,
            "message" => $message
        ]);
    }
}
