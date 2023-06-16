<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Despesa;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => 'password',
                'email_verified_at' => now(),
                'type' => 'admin'
            ]
        )->despesas()->saveMany(
            Despesa::factory(25)->make()
        );

        User::factory(5)
            ->isRegular()
            ->has(Despesa::factory(5))
            ->create();

        $this->call([
            DespesasSeeder::class,
        ]);
    }
}
