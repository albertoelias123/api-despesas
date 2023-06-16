<?php

namespace App\Http\Resources;

use App\Models\Despesa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;

class DespesaResource extends JsonResource
{
    /**
     * Transforma a instância do recurso em um array.
     */
    public function toArray($request)
    {
        $links = [];

        // Verifica se o usuário pode visualizar todas as despesas
        if (Gate::allows('viewAny', Despesa::find($this->id))) {
            $links[] = [
                'href' => route('despesas.index'),
                'rel' => "despesas.index",
                'type' => "GET|HEAD"
            ];
        }

        // Verifica se o usuário pode criar uma nova despesa
        if (Gate::allows('create', Despesa::class)) {
            $links[] = [
                'href' => route('despesas.store'),
                'rel' => "despesas.store",
                'type' => "POST"
            ];
        }

        // Verifica se o usuário pode visualizar uma despesa específica
        if (Gate::allows('view', Despesa::find($this->id))) {
            $links[] = [
                'href' => route('despesas.show', $this->id),
                'rel' => "despesas.show",
                'type' => "GET|HEAD"
            ];
        }

        // Verifica se o usuário pode atualizar uma despesa específica
        if (Gate::allows('update', Despesa::find($this->id))) {
            $links[] = [
                'href' => route('despesas.update', $this->id),
                'rel' => "despesas.update",
                'type' => "PUT|PATCH"
            ];
        }

        // Verifica se o usuário pode excluir uma despesa
        if (Gate::allows('delete', Despesa::class)) {
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
