<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Os atributos que podem ser atribuídos em massa.
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type'
    ];

    /**
     * Os atributos que devem ser ocultados na serialização.
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Os atributos que devem ser convertidos.
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'type' => UserType::class
    ];

    /**
     * Obtém as despesas associadas ao usuário.
     */
    public function despesas(): HasMany
    {
        return $this->hasMany(Despesa::class, 'dono');
    }

    /**
     * Verifica se o usuário é um administrador.
     */
    public function isAdministrator(): bool
    {
        return $this->type === 'admin';
    }

    /**
     * Verifica se o usuário é um moderador.
     */
    public function isMod(): bool
    {
        return $this->type === 'mod';
    }

    /**
     * Verifica se o usuário é um usuário regular.
     */
    public function isRegular(): bool
    {
        return $this->type === 'regular';
    }
}
