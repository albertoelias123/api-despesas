<?php

namespace App\Enums;

// Declaração da classe enum UserType, que representa os tipos de usuário
enum UserType: string
{
    // Definição da constante Admin, que representa o tipo de usuário "admin"
    const Admin = 'admin';

    // Definição da constante Mod, que representa o tipo de usuário "mod"
    const Mod = 'mod';

    // Definição da constante Regular, que representa o tipo de usuário "regular"
    const Regular = 'regular';
}
