<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\api\baseController;
use Illuminate\Validation\ValidationException;

class userController extends Controller
{
    public function login(Request $request){
        $validation = Validator::make($request->all(), [
            'user_name' => 'required',
            'password' => 'required'
        ]);
        if($validation->fails()){
            $errors = baseController::response(false, $validation->errors()->first(), [], 422);
            return $errors;
        }
        
        $user = User::where('user_name', $request->user_name)->first();

        if (!$user or !Hash::check($request->password, $user->password)) {
            $errors = baseController::response(false, 'username or password is incorrect', [], 422);
            return $errors;
        }
        $token = $user->createToken($request->user_name)->plainTextToken;

        return baseController::response(true, 'successful login', [
            'token'=>$token
        ]);
    }

    public function register(Request $request){
        $validation = Validator::make($request->all(), [
            'name'=>'required',
            'user_name' => 'required',
            'password' => 'required',
            'role_id'=>'required',
            'branch_id'=>'required'
        ]);
        if($validation->fails()){
            $errors = baseController::response(false, $validation->errors()->first(), [], 422);
            return $errors;
        }

        $user = User::where('user_name', $request->user_name)->first();

        if($user){
            return baseController::response(false, 'the user already exists');
        }

        User::create([
            'name'=>$request->name,
            'user_name'=>$request->user_name,
            'password'=>Hash::make($request->password),
            'role_id'=>$request->role_id,
            'branch_id'=>$request->branch_id
        ]);
        return baseController::response(true, 'successful registration');
    }
}
