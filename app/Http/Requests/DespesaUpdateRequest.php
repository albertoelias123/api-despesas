<?php

namespace App\Http\Requests;

use App\Models\Despesa;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Classe de requisição para atualização de uma despesa.
 *
 * Esta classe estende DespesaStoreRequest para utilizar o método prepareForValidation()
 * para preparar o atributo 'dono' antes da validação.
 */
class DespesaUpdateRequest extends DespesaStoreRequest
{
    /**
     * Define as regras de validação para a atualização de uma despesa.
     */
    public function rules(): array
    {
        return [
            'descricao' => 'sometimes|string|max:191', // A descrição é opcional e, se presente, deve ser uma string com no máximo 191 caracteres
            'data' => 'sometimes|date|before_or_equal:today', // A data é opcional e, se presente, deve ser uma data válida e ser anterior ou igual à data atual
            'valor' => 'sometimes|numeric|min:0', // O valor é opcional e, se presente, deve ser um número com um valor mínimo de 0
            'dono' => 'sometimes|numeric|exists:users,id' // O dono é opcional e, se presente, deve ser um número existente na tabela 'users' com um ID correspondente
        ];
    }
}
