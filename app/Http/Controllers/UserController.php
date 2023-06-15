<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

/**
     * Display a listing of the resource.
     */
    public function loginUser(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required'
        ]);

        if($validator->fails()){

            return Response(['message' => $validator->errors()],401);
        }

        if(Auth::attempt($request->only('email', 'password'))){

            $user = Auth::user();

            return Response(['token' => $user->createToken($request->device_name)->plainTextToken],200);
        }

        return Response(['message' => 'email or password wrong'],401);
    }

     /**
     * Store a newly created resource in storage.
     */
    public function userDetails(): Response
    {
        if (Auth::check()) {

            $user = Auth::user();

            return Response(['data' => $user],200);
        }

        return Response(['data' => 'Unauthorized'],401);
    }

    /**
     * Display the specified resource.
     */
    public function revokeAllTokens(Request $request): Response
    {
        $user = Auth::user();

        $user->tokens()->delete();

        //$request->user()->currentAccessToken()->delete();


        //dd($user->currentAccessToken());

        return Response(['data' => 'User Logout successfully.'],200);
    }
}
