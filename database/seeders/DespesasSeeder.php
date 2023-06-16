<?php

namespace Database\Seeders;

use App\Models\Despesa;
use App\Models\User;
use Illuminate\Database\Seeder;

class DespesasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Despesa::factory(200)->create();
    }
}
