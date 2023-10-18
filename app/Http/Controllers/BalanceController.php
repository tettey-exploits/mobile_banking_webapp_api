<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerBalanceRequest;
use App\Http\Resources\ResponseResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BalanceController extends Controller
{

    public function show($account_number): ResponseResource
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
