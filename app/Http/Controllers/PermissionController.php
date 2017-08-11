<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public function usersRoutePerms(Request $request) {
    	$user_id = $request->input("user_id");

        $user = \App\User::find($user_id);
        $group_id = $user['group_id'];

        $routePerms = \App\GroupRoutePermission::where("group_id",$group_id)->get();

        $table_fields = [
        	['label' => "Route Path","key"=>"route_path"]
        ];

    	return response()->json([
            'labels' => [
                'group' => "Route Permissions",
                'single' => "Route Permission"
            ],
            "tableFields" => $table_fields,
            'status' => 'success',
            'data' => $routePerms
        ]);
    }
}
