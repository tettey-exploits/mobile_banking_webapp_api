<?php

namespace App\Http\Controllers;

use App\Http\Resources\ResponseResource;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
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
    public function store(Request $request): ResponseResource
    {

        $balance_model = Customer::find($request->customer_id)->balance;
        $old_balance = $balance_model->balance;

        if($request->transaction_type_id == 1){ // 1 is deposit
            $transaction_type = "deposit_amount";
            $balance = $old_balance + $request->amount_ghs;
            $message = "Cash deposited successfully";
        }
        else{
            $transaction_type = "withdraw_amount";
            $balance = $old_balance - $request->amount_ghs;
            $message = "Cash withdrawn successfully";
        }

        if($balance < 0){
            $success = false;
            $message = "Balance is not enough to perform this operation!";
            $balance = $old_balance;
        }else{
            $balance_model->balance = $balance;
            $balance_model->save();
            $success = true;

            Transaction::create($request->all());
        }


        return ResponseResource::make([
            "success" => $success,
            "message" => $message,
            $transaction_type => $request->amount_ghs,
            "old_balance" => $old_balance,
            "new_balance" => $balance
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
