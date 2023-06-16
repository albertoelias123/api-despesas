<?php

namespace App\Http\Resources;

use App\Models\Despesa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

class DespesaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $links = [
            [
                'href' => route('despesas.index'),
                'rel' => "despesas.index",
                'type' => "GET|HEAD"
            ],
        ];

        if (Gate::allows('create', Despesa::class)) {
            $links[] = [
                'href' => route('despesas.store'),
                'rel' => "despesas.store",
                'type' => "POST"
            ];
        }

        if (Gate::allows('view', Despesa::find($this->id))) {
            $links[] = [
                'href' => route('despesas.show', $this->id),
                'rel' => "despesas.show",
                'type' => "GET|HEAD"
            ];
        }

        if (Gate::allows('update', Despesa::find($this->id))) {
            $links[] = [
                'href' => route('despesas.update', $this->id),
                'rel' => "despesas.update",
                'type' => "PUT|PATCH"
            ];
        }

        if (Gate::allows('delete', Despesa::find($this->id))) {
            $links[] = [
                'href' => route('despesas.destroy', $this->id),
                'rel' => "despesas.destroy",
                'type' => "DELETE"
            ];
        }

        return [
            'id' => $this->id,
            'descricao' => $this->descricao,
            'data' => $this->data,
            'valor' => $this->valor,
            'dono' => new UserResource(User::find($this->dono)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            '_links' => $links
        ];
    }
}
