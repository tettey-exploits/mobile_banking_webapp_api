<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignPermissionRequest;
use App\Http\Resources\ResponseResource;
use App\Models\Permission;
use App\Models\Role;

class AssignPermissionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(AssignPermissionRequest $request): ResponseResource
    {

        $role = Role::find($request->role_id);

        $result = $role->permissions()->syncWithoutDetaching($request->permission_ids);
        if (empty($result["attached"])) {
            $success = false;
            $message = "Permissions already assigned to roles";
        } else {
            $success = true;
            $message = "Permissions assigned to user";
        }

        return ResponseResource::make([
            "success" => $success,
            "message" => $message,
        ]);
    }

}
