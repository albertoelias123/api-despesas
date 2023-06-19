<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Despesa extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser atribuídos em massa.
     * @var array
     */
    protected $fillable = [
        'descricao',
        'data',
        'valor',
        'dono'
    ];

    /**
     * Os atributos que devem ser convertidos.
     * @var array
     */
    protected $casts = [
        'data' => 'date'
    ];

    /**
     * Obtém o usuário associado à despesa.
     */
    public function dono(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dono');
    }
}
