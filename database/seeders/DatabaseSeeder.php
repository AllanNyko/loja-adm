<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Ordem de execução:
        // 1. Usuários (independente)
        // 2. Clientes (independente)
        // 3. Produtos (independente)
        // 4. Despesas (independente)
        // 5. Ordens de Serviço (depende de clientes)
        // 6. Vendas (depende de clientes e produtos)
        
        $this->call([
            UserSeeder::class,
            CustomerSeeder::class,
            ProductSeeder::class,
            ExpenseSeeder::class,
            ServiceOrderSeeder::class,
            SaleSeeder::class,
        ]);
    }
}
