<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
{
    /**
     * Transforma a instância do recurso em um array.
     */
    public function toArray($request)
    {
        // Constrói o array de links
        $links = [
            [
                'href' => route('login'),
                'rel' => "login",
                'type' => "POST"
            ],
        ];

        // Adiciona links adicionais se o usuário estiver autenticado
        if (Auth::check()) {
            $links[] = [
                'href' => route('logout'),
                'rel' => "logout",
                'type' => "GET"
            ];

            $links[] = [
                'href' => route('authUser'),
                'rel' => "authUser",
                'type' => "GET"
            ];
        }

        // Retorna o array representando o recurso do usuário
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            '_links' => $links
        ];
    }
}
