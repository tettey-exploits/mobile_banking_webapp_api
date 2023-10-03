<?php

namespace App\Http\Controllers;

use App\Http\Resources\ResponseResource;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //
    public function userLogin(): JsonResponse
    {
        if (Auth::attempt(["email" => request("email"), "password" => request("password")])) {
            $user = User::find(Auth::user()["id"]);
            $user_token = $user->createToken("appToken")->plainTextToken;
            $data = [
                "user_data" => $user,
                "token" => $user_token
            ];
            $success = true;
            $message = "User authentication successful.";
            $status = 200;
        } else {
            $success = false;
            $data = [];
            $message = "User Authentication failed";
            $status = 401;

        }

        return response()->json([
            "success" => $success,
            "data" => $data,
            "message" => $message,
        ], $status);
    }

    public function customerLogin(Request $request): ResponseResource
    {
        $customer = Customer::where('email', $request["email"])->first();

        return !$customer || !Hash::check($request["password"], $customer->password) ? throw ValidationException::withMessages([
            'email' => ['The provided email or password is incorrect.'],
        ]) : ResponseResource::make([
            'success' => true,
            "data" => [
                "customer_data" => $customer,
                "token" => $customer->createToken($request["device_name"])->plainTextToken
            ],

        ]);

    }

}
