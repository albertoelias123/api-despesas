<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DespesaStoreRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        // Se o campo 'dono' estiver presente na solicitação,
        // realiza um typecasting para o tipo inteiro
        if ($this->has('dono')) {
            $this->merge(['dono' => (int) $this->input('dono')]);
        }
        // Caso contrário, define o dono como o ID do usuário autenticado
        else {
            $this->merge(['dono' => Auth::id()]);
        }
    }

    public function rules(): array
    {
        return [
            'descricao' => 'required|string|max:191', // Descrição é obrigatória, deve ser uma string e ter no máximo 191 caracteres
            'data' => 'required|date|before_or_equal:today', // Data é obrigatória, deve ser uma data válida e ser anterior ou igual à data atual
            'valor' => 'required|numeric|min:0', // Valor é obrigatório, deve ser um número e ter um valor mínimo de 0
            'dono' => 'required|numeric|exists:users,id' // Dono é obrigatório, deve ser um número e existir na tabela 'users' com um ID correspondente
        ];
    }
}
