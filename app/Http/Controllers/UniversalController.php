<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;

class UniversalController extends Controller
{

    public function all($resource) {
    	$model = '\\App\\'.$resource;

        $model = new $model;

    	$records = $model::all();

        $label = "";
        if (isset($model->label))
            $label = $model->label;

        $single_label="";
        if (isset($model->label_single))
            $single_label = $model->label_single;

        $table_fields="";
        if (isset($model->table_fields))
            $table_fields = $model->table_fields;

    	return response()->json([
            'labels' => [
                'group' => $label,
                'single' => $single_label
            ],
            "tableFields" => $table_fields,
            'status' => 'success',
            'data' => $records
        ]);
    }

    /**
    ACCEPTS:
        filters = [
            [field, operator, value, and/or = and]
        ],
        orders = [
            [field, 'ASC/DESC']
        ],
        relations = ['relation','relation'],
    **/
    public function filter(Request $request, $resource) {
        $input = $request->input();

        $model = '\\App\\'.$resource;
        $model = new $model;

        if (isset($input['filters'])) {
            $filters = json_decode($input['filters'],true);

            $cnt = 0;
            foreach ($filters as $filter) {

                if (!isset($filter[3]))
                    $filter[3] == "and";

                if ($filter[1] == 'like')
                    $filter[2] = "%".$filter[2]."%";

                if ($cnt == 0)
                    $model = $model->where($filter[0],$filter[1],$filter[2]);
                else {
                    if ($filter[3] == 'and')
                        $model = $model->where($filter[0],$filter[1],$filter[2]);
                    else
                        $model = $model->orWhere($filter[0],$filter[1],$filter[2]);
                }

                $cnt++;
            }
        }

        if (isset($input['orders'])) {
            $orders = json_decode($input['orders'],true);

            foreach ($orders as $order) {
                $model = $model->orderBy($order[0],$order[1]);
            }
        }

        $result = $model->get();

        $label = "";
        if (isset($model->label))
            $label = $model->label;

        $single_label="";
        if (isset($model->label_single))
            $single_label = $model->label_single;

        $table_fields="";
        if (isset($model->table_fields))
            $table_fields = $model->table_fields;

        return response()->json([
            'labels' => [
                'group' => $label,
                'single' => $single_label
            ],
            "tableFields" => $table_fields,
            'status' => 'success',
            'data' => $result
        ]);
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

    public function save(Request $request, $resource) {
    	$model = '\\App\\'.$resource;
        $model = new $model;

        $validation_rules = $model->validation_rules;
        $data = json_decode($request->input('fields'),true);

        if ($validation_rules)
            $validator = Validator::make($data,$validation_rules);

        
        if (isset($data['id'])) {
            $record = $model->find($data['id']);
            $id = $data['id'];

            $has_errors = false;
            if ($validation_rules && $validator->fails()) {
                //unset all fields where validation fails, so it doesn't save, but save all the rest

                foreach ($validator->getMessageBag() as $key => $value) {
                    unset($record->$key);
                }

                $has_errors = true;
            }

            foreach ($data as $key => $value) {
                if (Schema::hasColumn($record->getTable(),$key)){
                    $record->$key = $value;
                }
            }

            $record->save();

            if ($has_errors) {
                return response()->json([
                    'status' => "fail",
                    'errors' => $validator->getMessageBag(),
                    'message' => "Some fields are not correct.",
                    'id' => $id
                ]); 
            }
            
        }
        else {
            if ($validation_rules && $validator->fails()) {
                //validation failes on new record, don't save anything
                return response()->json([
                    'status' => "fail",
                    "message" => "Some fields are not correct.",
                    "errors" => $validator->getMessageBag()
                ]);
            }
            else {
                foreach ($data as $key => $value) {
                    if (Schema::hasColumn($model->getTable(),$key)){
                        $model->$key = $value;
                    }
                }
                $model->save();

                $id = $model->id;
            }
        }

        return response()->json([
            'status' => "success",
            'id' => $id
        ]);
        
    }
}
