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

        if($transaction_type == "deposit")
        {
            $transaction_response = $this->makeDeposit($request, $customer);
        }
        elseif($transaction_type == "withdraw")
        {
            $transaction_response = $this->makeWithDrawal($request, $customer);
        }

        return ResponseResource::make([
            "success" => $transaction_response["success"],
            "message" => $transaction_response["message"],
            "data" => [
                "transaction_type" => $transaction_type,
                "amount_ghs" => $request->amount_ghs,
                "old_balance" => $old_balance,
                "new_balance" => $transaction_response["balance"]
            ]
        ]);
    }

    private function makeDeposit($request, $customer): array
    {

        $old_balance = $customer->balance->balance;
        $balance = $old_balance + $request->amount_ghs;

        Transaction::create([
            "user_id" => Auth::user()->id,
            "customer_account_number" => $request->customer_account_number,
            "amount_ghs" => $request->amount_ghs,
            "transaction_type_id" => $request->transaction_type_id
        ]);
        $customer->balance->balance = $balance;
        $customer->balance->save();

        return [
            "success" => true,
            "message" => "Cash deposit successful",
            "balance" => $balance
        ];
    }

    private function makeWithDrawal($request, $customer): array
    {
        $old_balance = $customer->balance->balance;
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

        return [
            "success" => $success,
            "message" => $message,
            "balance" => $balance
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show($account_number)
    {
        return Transaction::where("customer_account_number", $account_number)->get();
    }

}
