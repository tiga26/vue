<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Test::all()->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Store a newly created test in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $rules = [
            'name' => 'required|min:3|max:255'
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            $test = new Test();
            $test->name = array_get($data, 'name');
            $test->save();
            return response($test->jsonSerialize(), Response::HTTP_CREATED);
        }

        return response(json_encode($validator->errors()->all()), Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
