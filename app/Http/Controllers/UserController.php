<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManageUserRequest;
use App\Http\Resources\ResponseResource;
use App\Models\Role;
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
    public function store(ManageUserRequest $request): ResponseResource
    {
        //
        $new_user = User::create($request->all());
        $role = Role::find($request->role);
        $new_user->roles()->attach($role);

        return ResponseResource::make([
            "success" => true,
            "message" => "New user added.",
            "data" => [
                "new_user" => $new_user
            ]
        ]);

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
    public function update(Request $request, User $user): ResponseResource
    {
        //
        $update_resource = $request->update_resource;
        $update_details = $request->update_details;

        switch ($update_resource){
            case "update_user_details":
                $this->update_user_details($update_details, $user);
                break;
            case "update_user_password":
                $this->update_user_password($update_details, $user);
                break;
            case "update_user_role":
                $this->update_user_role($update_details, $user);
                break;
            default:
                return ResponseResource::make([
                    "success" => false,
                    "message" => "Unknown resource request"
                ]);
        }

        return ResponseResource::make([
            "success" => true,
            "message" => "Resource update successful"
        ]);
    }

    public function update_user_details ($update_details, $user)
    {

    }

    public function update_user_password ($update_details, $user)
    {

    }

    private function update_user_role($update_details, $user): void
    {
        $user->roles()->attach($update_details["role_id"]);
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
        } catch (Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return ResponseResource::make([
            "success" => $success,
            "message" => $message
        ]);
    }
}
