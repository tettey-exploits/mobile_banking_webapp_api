<?php

namespace App\Http\Controllers;

use App\Http\Resources\ResponseResource;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): ResponseResource
    {
        try {
            $customer = Customer::with("balance")->find($request["account_number"]);
            $transaction_type = TransactionType::findOrFail($request["transaction_type_id"])->transaction_type;
            $old_balance = $customer->balance->balance;
        } catch (ModelNotFoundException) {
            return ResponseResource::make([
                "success" => false,
                "message" => "Operation failed! Unknown transaction request.",
                "data" => []
            ]);
        }

        if($transaction_type == "deposit") {
            $balance = $old_balance + $request["amount_ghs"];
            $message = "Cash deposited successfully";
            $success = true;

            Auth::user()->transactions->create([$request->all()]);
            $customer->balance->create(["balance" => $balance]);
        } elseif($transaction_type == "withdraw") {
            $balance = $old_balance - $request->amount_ghs;
            $message = "Cash withdrawn successfully";
            $success = true;

            if($balance < 0) {
                $success = false;
                $message = "Transaction failed. Your balance is not enough!";
                $balance = $old_balance;
            }
        }

        return ResponseResource::make([
            "success" => $success,
            "message" => $message,
            "data" => [
                "transaction_type" => $transaction_type,
                "amount_ghs" => $request->amount_ghs,
                "old_balance" => $old_balance,
                "new_balance" => $balance
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
