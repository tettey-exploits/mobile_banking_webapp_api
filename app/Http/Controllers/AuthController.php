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
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = User::find(Auth::user()->id);

            $user_token['token'] = $user->createToken('appToken')->plainTextToken;

            return response()->json([
                'success' => true,
                'token' => $user_token,
                'user' => $user,
            ], 200);
        } else {
            // failure to authenticate
            return response()->json([
                'success' => false,
                'message' => 'Failed to authenticate.',
            ], 401);
        }
    }

    public function customerLogin(Request $request): ResponseResource
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
            'device_name'=>'required'
        ]);

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer || !Hash::check($request->password, $customer->password)) {

            throw ValidationException::withMessages([
                'email' => ['The provided email or password is incorrect.'],
            ]);
        }

        return ResponseResource::make([
            'success'=>true,
            "customer info"=> $customer,
            "token"=> $customer->createToken($request->device_name)->plainTextToken
        ]);
    }

}
