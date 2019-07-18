<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\Test as TestResource;
use App\Http\Resources\Tests as TestsCollection;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return response(Test::all()->jsonSerialize(), Response::HTTP_OK);
        return response(new TestsCollection(Test::orderBy('created_at', 'desc')->get()), Response::HTTP_OK);
        
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
            return response(new TestResource($test), Response::HTTP_CREATED);
        }

        return response($validator->errors()->toJson(), Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
