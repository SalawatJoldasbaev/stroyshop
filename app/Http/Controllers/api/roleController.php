<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class roleController extends Controller
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
        //
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
            'name' => 'required',
            'branch_id' => 'required'
        ]);
        if($validation->fails()){
            return baseController::response(false, $validation->errors()->first(), [], 422);
        }

        if(role::where('branch_id', $request->branch_id)->where('name', $request->name)->first()){
            return baseController::response(false, 'the role already exists', [], 409);
        }

        if($request->user()->role_id == 1 or $request->user()->role_id == 0){
             role::create([
                'name'=>$request->name,
                'branch_id'=>$request->branch_id
            ]);
        }

        return baseController::response(true, 'successful created role', [], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(role $role)
    {
        if((Auth::user()->role_id == 1 and Auth::user()->branch_id == $role->branch_id) or Auth::user()->role_id == 0){
            $role->delete();
            return baseController::response(true, 'successful deleted role', [], 200);
        }

        return baseController::response(false, 'not found role', [], 404);
    }
}
