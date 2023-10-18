<?php

namespace App\Http\Controllers;

use App\Http\Resources\ResponseResource;
use App\Models\Customer;

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

}
