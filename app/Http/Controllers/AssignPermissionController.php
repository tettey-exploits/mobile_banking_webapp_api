<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignPermissionRequest;
use App\Http\Resources\ResponseResource;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class AssignPermissionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(AssignPermissionRequest $request): ResponseResource
    {

        $roles = Role::find($request->role_ids);

        foreach ($roles as $role)
        {
            $role->permissions()->attach($request->permission_id);
        }

        return ResponseResource::make([
            "success" => true,
            "message" => "Permission assigned to user",
            "assigned_permission" => Permission::find($request->permission_id)->permission
        ]);
    }

}
