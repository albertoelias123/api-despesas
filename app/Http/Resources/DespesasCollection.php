<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DespesasCollection extends ResourceCollection
{
    // Define o nome do atributo de envolvimento para a coleção
    public static $wrap = 'despesas';

    /**
     * Transforma a coleção de recursos em um array.
     */
    public function toArray($request)
    {
        return [
            'despesas' => $this->collection, // Atribui a coleção de despesas
        ];
    }
}
