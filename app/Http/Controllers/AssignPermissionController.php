<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignPermissionRequest;
use App\Http\Resources\ResponseResource;
use App\Models\Role;

class AssignPermissionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(AssignPermissionRequest $request): ResponseResource
    {
        $role = Role::find($request->role_id);
        $action = $request->action;

        if ($action == "attach") {
            $result = $role->permissions()->syncWithoutDetaching($request->permission_ids);
            if (empty($result["attached"])) {
                $success = false;
                $message = "Permissions already assigned to roles";
            } else {
                $success = true;
                $message = "Permissions assigned to user";
            }
        } else {
            $num = $role->permissions()->detach($request->permission_ids);
            $message = "$num permissions successfully revoked";
            $success = $num > 0;
        }

        return ResponseResource::make([
            "success" => $success,
            "message" => $message,
        ]);
    }

}
