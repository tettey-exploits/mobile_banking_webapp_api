<?php

namespace App\Http\Controllers;

use App\Http\Resources\ResponseResource;
use App\Models\Balance;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function show(string $id): ResponseResource
    {

        $customer = auth()->user();
        $balance = $customer->balance;

        return ResponseResource::make([
            "balance" => $balance
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
