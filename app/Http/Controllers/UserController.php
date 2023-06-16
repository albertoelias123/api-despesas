<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

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


    public function authUserDetails(): Response
    {
        if (Auth::check()) {

            $user = Auth::user();

            return Response(new UserResource($user),200);
        }

        return Response(['data' => 'Unauthorized'],401);
    }

    public function revokeAllTokens(Request $request): Response
    {
        $user = Auth::user();

        $user->tokens()->delete();

        return Response(['data' => 'User Logout successfully.'],200);
    }
}
