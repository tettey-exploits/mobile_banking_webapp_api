<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionsRequest;
use App\Http\Resources\ResponseResource;
use App\Models\Customer;
use App\Models\Permission;
use App\Models\Transaction;
use App\Models\TransactionType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ResponseResource
    {
        $transactions = Transaction::with("customer")->paginate(25);
        return ResponseResource::make($transactions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionsRequest $request): ResponseResource
    {

        if (Auth::user()->username != NULL) // Check if current user is not a customer
            abort(404);

        $this->authorize("create", Transaction::class);

        try {
            $customer = Customer::with("balance")->where("account_number", $request["customer_account_number"])->first();
            if($customer == Null)
                throw new ModelNotFoundException;
            $transaction_type = TransactionType::find($request["transaction_type_id"])->transaction_type;
            $old_balance = $customer->balance->balance;
        } catch (ModelNotFoundException $exception) {
            return ResponseResource::make([
                "success" => false,
                "message" => "Customer with account number {$request["customer_account_number"]} does not exist",
                "data" => []
            ]);
        }

        if($transaction_type == "deposit") {
            $balance = $old_balance + $request->amount_ghs;
            $message = "Cash deposited successfully";
            $success = true;

            Transaction::create([
                "user_id" => Auth::user()->id,
                "customer_account_number" => $request->customer_account_number,
                "amount_ghs" => $request->amount_ghs,
                "transaction_type_id" => $request->transaction_type_id
            ]);
            $customer->balance->balance = $balance;
            $customer->balance->save();
        } elseif($transaction_type == "withdraw") {
            $balance = $old_balance - $request->amount_ghs;
            $message = "Cash withdrawn successfully";
            $success = true;

            if($balance < 0) {
                $success = false;
                $message = "Transaction failed. Your balance is not enough!";
                $balance = $old_balance;
            }

            $customer->balance->balance = $balance;
            $customer->balance->save();
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
