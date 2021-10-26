<?php

namespace App\Http\Controllers\api;

use App\Models\product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\api\baseController;
use Illuminate\Support\Facades\Auth;

class productController extends Controller
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
        $image = $request->file('image');
        $image_path = $image->store('product', 'public');

        $validation = Validator::make($request->all(), [
            'name'  => 'required',
            'price' => 'required',
            'image' => 'required|image:jpeg,png,jpg,gif,svg'
        ]);

        if($validation->fails()){
            $errors = baseController::response(false, $validation->errors()->first(), [], 422);
            return response($errors, 422);
        
        }
        
        $product = product::create([
            'branch_id'=>$request->user()->branch_id,
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=> $request->price,
            'image'=> Storage::url($image_path) 
        ]);

        return baseController::response(true, 'successful created', ['id'=>$product->id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(product $product){
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    
    public function update(Request $request, product $product){
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(product $product)
    {
        if($product->branch_id == Auth::user()->branch_id or Auth::user()->branch_id   == 0){
            $product->delete();
            return baseController::response(true, 'successful deleted');
        }
    }
}
