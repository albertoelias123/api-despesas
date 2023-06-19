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
    /**
     * Realiza a autenticação do usuário.
     *
     * Valida os campos 'email', 'password' e 'device_name' presentes na requisição.
     * Em caso de falha na validação, retorna uma resposta de erro 401 com as mensagens de validação.
     * Em caso de sucesso na validação, verifica se as credenciais fornecidas são válidas e autentica o usuário.
     * Retorna uma resposta de sucesso 200 contendo o token gerado para o dispositivo informado.
     * Em caso de falha na autenticação, retorna uma resposta de erro 401 com uma mensagem informando que o email ou senha está incorreto.
     *
     */
    public function loginUser(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required'
        ]);

        if ($validator->fails()) {
            return response([
                'message' => 'Os dados fornecidos para login são inválidos',
                'errors' => $validator->errors()
            ], 422);
        }


        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            return Response(['token' => $user->createToken($request->device_name)->plainTextToken], 200);
        }

        return Response(['message' => 'email or password wrong'], 401);
    }

    /**
     * Retorna os detalhes do usuário autenticado.
     *
     * Verifica se o usuário está autenticado.
     * Em caso afirmativo, recupera o usuário autenticado e retorna uma resposta de sucesso 200 contendo os detalhes do usuário no formato UserResource.
     * Em caso negativo, retorna uma resposta de erro 401 informando que a requisição não está autorizada.
     *
     */
    public function authUserDetails(): Response
    {
        $user = Auth::user();
        return Response(new UserResource($user), 200);
    }

    /**
     * Revoga todos os tokens de acesso do usuário autenticado.
     *
     * Recupera o usuário autenticado.
     * Deleta todos os tokens de acesso associados ao usuário.
     * Retorna uma resposta de sucesso 200 informando que o logout foi realizado com sucesso.
     *
     */
    public function revokeAllTokens(Request $request): Response
    {
        $user = Auth::user();
        $user->tokens()->delete();

        return Response(['data' => 'User Logout successfully.'], 200);
    }
}
