<?php

namespace App\Policies;

use App\Models\Despesa;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DespesaPolicy
{
    /**
     * Determina se o usuário pode visualizar uma lista de despesas.
     */
    public function viewAny()
    {
        return Response::allow();
    }

    /**
     * Determina se o usuário pode visualizar uma despesa específica.
     */
    public function view($user, $despesa)
    {
        return $user->id === $despesa->dono || $user->isMod()
            ? Response::allow()
            : Response::deny('Você não pode ver esta despesa');
    }

    /**
     * Determina se o usuário pode criar uma nova despesa.
     */
    public function create($user)
    {
        // Verifica se o usuário tem o e-mail verificado
        if ($user->hasVerifiedEmail()) {
            return Response::allow();
        } else {
            return Response::deny('Seu e-mail não foi verificado');
        }
    }

    /**
     * Determina se o usuário pode atualizar uma despesa existente.
     */
    public function update($user, $despesa)
    {
        // Verifica se o usuário tem o e-mail verificado e se é o dono da despesa
        if ($user->hasVerifiedEmail() && $user?->id === $despesa?->dono) {
            return Response::allow();
        } else {
            return Response::deny('Você não pode atualizar esta despesa');
        }
    }

    /**
     * Determina se o usuário pode excluir uma despesa.
     */
    public function delete($user)
    {
        // Verifica se o usuário é um Moderador
        if ($user->isMod()) {
            return Response::allow();
        } else {
            return Response::deny('Apenas Moderadores podem excluir despesas');
        }
    }

    /**
     * Executado antes de todas as outras verificações de autorização.
     * Permite que o administrador ignore as outras verificações e tenha acesso completo.
     */
    public function before($user, $ability)
    {
        if ($user->isAdministrator()) {
            return true;
        }

        return null;
    }
}
