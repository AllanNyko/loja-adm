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
        // Criar usuário admin padrão
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@jdsmart.com',
            'password' => Hash::make('admin123'),
        ]);

        // Criar usuário teste
        User::create([
            'name' => 'João Silva',
            'email' => 'joao@jdsmart.com',
            'password' => Hash::make('senha123'),
        ]);
    }
}
