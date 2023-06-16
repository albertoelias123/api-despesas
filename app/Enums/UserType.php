<?php

namespace App\Enums;

enum UserType: string
{
    const Admin = 'admin';
    const Mod = 'mod';
    const Regular = 'regular';
}
