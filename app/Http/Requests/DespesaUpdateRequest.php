<?php

namespace App\Http\Requests;

use App\Models\Despesa;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DespesaUpdateRequest extends DespesaStoreRequest
{

    public function rules(): array
    {
        return [
            'descricao' => 'sometimes|string|max:191',
            'data' => 'sometimes|date|before_or_equal:today',
            'valor' => 'sometimes|numeric|min:0',
            'dono' => 'sometimes|numeric|exists:users,id'
        ];
    }
}
