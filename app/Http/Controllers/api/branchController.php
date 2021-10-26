<?php

namespace App\Http\Controllers\api;

use App\Models\branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class branchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if($validation->fails()){
            return baseController::response(false, $validation->errors()->first(), [], 422);
        }

        if($request->user()->role_id != 0 or branch::where('name', $request->name)->first()){
            return baseController::response(false, 'not created branch, you are not mega admin or this is branch already exists', [], 400);
        }
        $branch = branch::create([
            'name'=>$request->name
        ]);
        return baseController::response(true, 'successful created branch', ['id'=>$branch->id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function edit(branch $branch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, branch $branch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(branch $branch)
    {
        //
    }
}
