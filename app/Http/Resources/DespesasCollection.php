<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DespesasCollection extends ResourceCollection
{
    public static $wrap = 'despesas';

    public function toArray(Request $request): array
    {
        return [
            'despesas' => $this->collection,
        ];
    }
}
