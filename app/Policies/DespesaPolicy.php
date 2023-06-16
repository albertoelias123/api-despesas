<?php

namespace App\Policies;

use App\Models\Despesa;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DespesaPolicy
{

    public function viewAny(User $user): Response
    {
        return Response::allow();
    }

    public function view(User $user, Despesa $despesa): Response
    {
        return $user->id === $despesa->dono || $user->isMod()
            ? Response::allow()
            : Response::deny('Você não pode ver esta despesa');
    }

    public function create(User $user): Response
    {
        // Verifica se o usuário tem o e-mail verificado
        if ($user->hasVerifiedEmail()) {
            return Response::allow();
        } else {
            return Response::deny('Seu e-mail não foi verificado');
        }
    }

    public function update(User $user, Despesa $despesa): Response
    {
        // Verifica se o usuário tem o e-mail verificado e se é o dono da despesa
        if ($user->hasVerifiedEmail() && $user?->id === $despesa?->dono) {
            return Response::allow();
        } else {
            return Response::deny('Você não pode atualizar esta despesa');
        }
    }

    public function delete(User $user, Despesa $despesa): Response
    {
        // Verifica se o usuário é um Moderador
        if ($user->isMod()) {
            return Response::allow();
        } else {
            return Response::deny('Apenas Moderadores podem excluir despesas');
        }
    }

    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdministrator()) {
            return true;
        }

        return null;
    }
}
