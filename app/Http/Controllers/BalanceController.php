<?php

namespace App\Http\Controllers;

use App\Http\Resources\ResponseResource;
use App\Models\Customer;
use Illuminate\Http\Request;

class BalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**$balance->customer()
     * Display the specified resource.
     */
    public function show(string $account_number): ResponseResource
    {

        $data = [];
        $success = false;
        $customer = Customer::where("account_number", $account_number)->first();

        if($customer) {
            $data = $customer->balance;
            $success = true;
        }

        return ResponseResource::make([
            "success" => $success,
            "data" => $data
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}
