<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar usuário admin padrão se não existir
        User::firstOrCreate(
            ['email' => 'admin@jdsmart.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123'),
            ]
        );

        // Criar usuário teste se não existir
        User::firstOrCreate(
            ['email' => 'joao@jdsmart.com'],
            [
                'name' => 'João Silva',
                'password' => Hash::make('senha123'),
            ]
        );
    }
}
