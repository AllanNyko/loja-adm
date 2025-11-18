<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\ServiceOrder;
use App\Models\Sale;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Criar clientes
        $customers = [
            [
                'name' => 'João Silva',
                'phone' => '(11) 98765-4321',
                'email' => 'joao@example.com',
                'address' => 'Rua das Flores, 123 - São Paulo, SP',
            ],
            [
                'name' => 'Maria Santos',
                'phone' => '(11) 97654-3210',
                'email' => 'maria@example.com',
                'address' => 'Av. Paulista, 456 - São Paulo, SP',
            ],
            [
                'name' => 'Pedro Oliveira',
                'phone' => '(11) 96543-2109',
                'email' => 'pedro@example.com',
                'address' => null,
            ],
            [
                'name' => 'Ana Costa',
                'phone' => '(11) 95432-1098',
                'email' => null,
                'address' => 'Rua da Consolação, 789 - São Paulo, SP',
            ],
        ];

        foreach ($customers as $customerData) {
            Customer::create($customerData);
        }

        // Criar produtos
        $products = [
            [
                'name' => 'Película de Vidro Temperado',
                'description' => 'Película protetora 9H para diversos modelos',
                'price' => 25.90,
                'stock' => 50,
                'category' => 'acessorio',
            ],
            [
                'name' => 'Capa de Silicone',
                'description' => 'Capa protetora em silicone flexível',
                'price' => 19.90,
                'stock' => 35,
                'category' => 'acessorio',
            ],
            [
                'name' => 'Carregador Tipo-C',
                'description' => 'Carregador rápido USB-C 20W',
                'price' => 45.00,
                'stock' => 20,
                'category' => 'acessorio',
            ],
            [
                'name' => 'Fone de Ouvido Bluetooth',
                'description' => 'Fone sem fio com cancelamento de ruído',
                'price' => 89.90,
                'stock' => 15,
                'category' => 'acessorio',
            ],
            [
                'name' => 'Display LCD iPhone 11',
                'description' => 'Tela de reposição original',
                'price' => 350.00,
                'stock' => 5,
                'category' => 'peça',
            ],
            [
                'name' => 'Bateria Samsung Galaxy A32',
                'description' => 'Bateria original 5000mAh',
                'price' => 120.00,
                'stock' => 8,
                'category' => 'peça',
            ],
            [
                'name' => 'Cabo USB-C',
                'description' => 'Cabo de dados e carregamento 1m',
                'price' => 15.90,
                'stock' => 45,
                'category' => 'acessorio',
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        // Criar ordens de serviço
        $serviceOrders = [
            [
                'customer_id' => 1,
                'device_model' => 'iPhone 11',
                'device_imei' => '123456789012345',
                'problem_description' => 'Tela trincada após queda',
                'diagnostic' => 'Necessário trocar display completo',
                'estimated_cost' => 450.00,
                'final_cost' => null,
                'status' => 'approved',
                'deadline' => now()->addDays(3),
                'notes' => 'Cliente solicitou urgência',
            ],
            [
                'customer_id' => 2,
                'device_model' => 'Samsung Galaxy A32',
                'device_imei' => '987654321098765',
                'problem_description' => 'Bateria descarregando rápido',
                'diagnostic' => 'Bateria com vida útil esgotada',
                'estimated_cost' => 180.00,
                'final_cost' => null,
                'status' => 'in_progress',
                'deadline' => now()->addDays(2),
                'notes' => null,
            ],
            [
                'customer_id' => 3,
                'device_model' => 'Xiaomi Redmi Note 10',
                'device_imei' => null,
                'problem_description' => 'Não está carregando',
                'diagnostic' => null,
                'estimated_cost' => null,
                'final_cost' => null,
                'status' => 'pending',
                'deadline' => null,
                'notes' => 'Aguardando aprovação do orçamento',
            ],
            [
                'customer_id' => 1,
                'device_model' => 'iPhone 13',
                'device_imei' => '456789123456789',
                'problem_description' => 'Alto-falante sem som',
                'diagnostic' => 'Alto-falante queimado',
                'estimated_cost' => 200.00,
                'final_cost' => 200.00,
                'status' => 'completed',
                'deadline' => now()->subDays(2),
                'notes' => 'Serviço concluído com sucesso',
            ],
        ];

        foreach ($serviceOrders as $orderData) {
            ServiceOrder::create($orderData);
        }

        // Criar algumas vendas
        $sale1 = Sale::create([
            'customer_id' => 2,
            'total' => 51.80,
            'payment_method' => 'pix',
            'notes' => null,
        ]);

        $sale1->items()->create([
            'product_id' => 1, // Película
            'quantity' => 2,
            'unit_price' => 25.90,
            'subtotal' => 51.80,
        ]);

        $sale2 = Sale::create([
            'customer_id' => 4,
            'total' => 154.80,
            'payment_method' => 'cartao_credito',
            'notes' => 'Parcelado em 3x',
        ]);

        $sale2->items()->create([
            'product_id' => 4, // Fone Bluetooth
            'quantity' => 1,
            'unit_price' => 89.90,
            'subtotal' => 89.90,
        ]);

        $sale2->items()->create([
            'product_id' => 3, // Carregador
            'quantity' => 1,
            'unit_price' => 45.00,
            'subtotal' => 45.00,
        ]);

        $sale2->items()->create([
            'product_id' => 2, // Capa
            'quantity' => 1,
            'unit_price' => 19.90,
            'subtotal' => 19.90,
        ]);

        // Atualizar estoque
        Product::find(1)->decrement('stock', 2);
        Product::find(2)->decrement('stock', 1);
        Product::find(3)->decrement('stock', 1);
        Product::find(4)->decrement('stock', 1);
    }
}
