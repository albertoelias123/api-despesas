<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $links = [
            [
                'href' => route('login'),
                'rel' => "login",
                'type' => "POST"
            ],
        ];

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
