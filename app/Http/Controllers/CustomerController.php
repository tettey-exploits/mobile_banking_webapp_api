<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManageCustomerRequest;
use App\Http\Resources\ResponseResource;
use App\Models\Balance;
use App\Models\Customer;
use Exception;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ResponseResource
    {
        $customers = Customer::with("balance")->paginate(25);

        return ResponseResource::make($customers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ManageCustomerRequest $request): ResponseResource
    {
        try {
            $account_number = date("dmy") . random_int(100000, 999999);
        } catch (Exception) {
            return ResponseResource::make([
                "success" => false,
                "message" => "Could not generate relevant information. Please try again later",
                "data" => []
            ]);
        }

        $new_customer_details = $request->merge([
            'password' => Hash::make($request["password"]),
            "account_number" => $account_number
        ]);

        $new_customer = Customer::create($new_customer_details->all());

        Balance::insert([  // Create an associated balance record
            "customer_id" => $new_customer->id,
            "balance" => 0.00,
            "created_at" => now(),
            "updated_at" => now()
        ]);

        return ResponseResource::make([
            "success" => true,
            "message" => "Customer account created successfully.",
            "data" => [
                "new_customer" => $new_customer
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer): ResponseResource
    {
        $customer->load("balance");
        return ResponseResource::make([
            "success" => true,
            "data" => [
                "customer_data" => $customer
            ]
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ManageCustomerRequest $request, Customer $customer): ResponseResource
    {
        $customer["first_name"] = $request->first_nam;
        $customer["last_name"] = $request->last_name;
        $customer["date_of_birth"] = $request->date_of_birth;
        $customer["contact"] = $request->contact;
        $customer["location"] = $request->location;
        $customer["email"] = $request->email;

        if($customer->update()) {
            return ResponseResource::make([
                "success" => true,
                "message" => "Customer records update successful",
                "data" => [
                    "customer_data" => $customer
                ]
            ]);
        }

        return ResponseResource::make([
            "success" => false,
            "message" => "Customer records update failed",
            "data" => [
                "customer_data" => []
            ]
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer): ResponseResource
    {
        try {
            if($customer->balance->delete()) {
                $customer->delete();
            }
            $success = true;
            $message = "Customer records successfully deleted";
        } catch (Exception $e) {
            $success = false;
            $message = "Could not delete customer records";
        }

        return ResponseResource::make([
            "success" => $success,
            "message" => $message
        ]);
    }
}
