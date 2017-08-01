<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function all($resource) {
    	$model = '\\App\\'.$resource;

    	$records = $model::all();

    	return response()->json($records);
    }

    public function find($resource, $id) {
    	$model = '\\App\\'.$resource;

    	$record = $model::find($id);

    	return response()->json($record);
    }

    public function delete(Request $request, $resource) {
    	$model = '\\App\\'.$resource;

    	$id = $request->input('id');

    	$record = $model::find($id);

    	$record->delete();

    	return response()->json([
    		'status' => 'success'
    	]);
    }

    public function save(Request $request) {
    	$model = '\\App\\'.$resource;

    	
    }
}
