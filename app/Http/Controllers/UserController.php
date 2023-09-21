<?php

namespace App\Http\Controllers;

use App\Http\Resources\ResponseResource;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ResponseResource
    {
        return ResponseResource::make(User::with("roles")->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): ResponseResource
    {
        return ResponseResource::make($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): ResponseResource
    {
        try {
            $user->delete();
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