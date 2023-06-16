<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DespesaStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        $authUser = Auth::user();

        // Verifica se o usuário está autenticado e se o e-mail já foi verificado
        if ($authUser?->hasVerifiedEmail())
            // Verifica se o user_id informado é igual ao id do usuário autenticado
            // Pois o usuário só pode criar despesas para si mesmo
            return $this->input('dono') === $authUser->id;


        return false;
    }

    protected function prepareForValidation(): void
    {
       // Se tiver dono, faz typecasting pra int
        if ($this->has('dono'))
            $this->merge(['dono' => (int) $this->input('dono') ]);
        // Se não tiver dono, define como o id do usuário autenticado
        else
            $this->merge(['dono' => Auth::id()]);

    }

    public function rules(): array
    {
        return [
            'descricao' => 'required|string|max:191',
            'data' => 'required|date|before_or_equal:today',
            'valor' => 'required|numeric|min:0',
            'dono' => 'required|numeric|exists:users,id'
        ];
    }
}
