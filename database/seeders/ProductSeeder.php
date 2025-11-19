<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Remove todos os registros mantendo auto-increment
        Product::query()->delete();

        $products = [
            // Acessórios
            [
                'name' => 'Película de Vidro Temperado',
                'description' => 'Película protetora 9H para diversos modelos',
                'price' => 25.90,
                'stock' => 150,
                'category' => 'acessorio',
                'created_at' => Carbon::create(2025, 1, 2, 9, 0),
            ],
            [
                'name' => 'Capa de Silicone',
                'description' => 'Capa protetora em silicone flexível',
                'price' => 19.90,
                'stock' => 200,
                'category' => 'acessorio',
                'created_at' => Carbon::create(2025, 1, 2, 9, 15),
            ],
            [
                'name' => 'Capa Tipo Carteira',
                'description' => 'Capa com porta-cartões em couro sintético',
                'price' => 35.90,
                'stock' => 80,
                'category' => 'acessorio',
                'created_at' => Carbon::create(2025, 1, 2, 9, 30),
            ],
            [
                'name' => 'Carregador Tipo-C 20W',
                'description' => 'Carregador rápido USB-C',
                'price' => 45.00,
                'stock' => 120,
                'category' => 'acessorio',
                'created_at' => Carbon::create(2025, 1, 2, 10, 0),
            ],
            [
                'name' => 'Cabo USB-C 1m',
                'description' => 'Cabo de dados e carregamento',
                'price' => 15.90,
                'stock' => 250,
                'category' => 'acessorio',
                'created_at' => Carbon::create(2025, 1, 2, 10, 15),
            ],
            [
                'name' => 'Cabo Lightning 1m',
                'description' => 'Cabo original para iPhone',
                'price' => 35.00,
                'stock' => 100,
                'category' => 'acessorio',
                'created_at' => Carbon::create(2025, 1, 2, 10, 30),
            ],
            [
                'name' => 'Fone de Ouvido Bluetooth',
                'description' => 'Fone sem fio com cancelamento de ruído',
                'price' => 89.90,
                'stock' => 60,
                'category' => 'acessorio',
                'created_at' => Carbon::create(2025, 1, 2, 11, 0),
            ],
            [
                'name' => 'Fone de Ouvido com Fio',
                'description' => 'Fone P2 com microfone',
                'price' => 25.00,
                'stock' => 90,
                'category' => 'acessorio',
                'created_at' => Carbon::create(2025, 1, 2, 11, 15),
            ],
            [
                'name' => 'Suporte Veicular Magnético',
                'description' => 'Suporte para carro com imã',
                'price' => 39.90,
                'stock' => 70,
                'category' => 'acessorio',
                'created_at' => Carbon::create(2025, 1, 2, 11, 30),
            ],
            [
                'name' => 'Pop Socket',
                'description' => 'Suporte expansível para celular',
                'price' => 12.90,
                'stock' => 150,
                'category' => 'acessorio',
                'created_at' => Carbon::create(2025, 1, 2, 11, 45),
            ],

            // Peças para Reparo
            [
                'name' => 'Display LCD iPhone 11',
                'description' => 'Tela de reposição original',
                'price' => 350.00,
                'stock' => 15,
                'category' => 'peça',
                'created_at' => Carbon::create(2025, 1, 3, 9, 0),
            ],
            [
                'name' => 'Display LCD iPhone 12',
                'description' => 'Tela de reposição original',
                'price' => 450.00,
                'stock' => 12,
                'category' => 'peça',
                'created_at' => Carbon::create(2025, 1, 3, 9, 30),
            ],
            [
                'name' => 'Display LCD Samsung A32',
                'description' => 'Tela de reposição original',
                'price' => 280.00,
                'stock' => 10,
                'category' => 'peça',
                'created_at' => Carbon::create(2025, 1, 3, 10, 0),
            ],
            [
                'name' => 'Bateria iPhone 11',
                'description' => 'Bateria original 3110mAh',
                'price' => 150.00,
                'stock' => 20,
                'category' => 'peça',
                'created_at' => Carbon::create(2025, 1, 3, 10, 30),
            ],
            [
                'name' => 'Bateria Samsung Galaxy A32',
                'description' => 'Bateria original 5000mAh',
                'price' => 120.00,
                'stock' => 18,
                'category' => 'peça',
                'created_at' => Carbon::create(2025, 1, 3, 11, 0),
            ],
            [
                'name' => 'Bateria Motorola G9 Plus',
                'description' => 'Bateria original 5000mAh',
                'price' => 110.00,
                'stock' => 15,
                'category' => 'peça',
                'created_at' => Carbon::create(2025, 1, 3, 11, 30),
            ],
            [
                'name' => 'Conector de Carga USB-C',
                'description' => 'Flex de carga Samsung/Motorola',
                'price' => 45.00,
                'stock' => 25,
                'category' => 'peça',
                'created_at' => Carbon::create(2025, 1, 3, 12, 0),
            ],
            [
                'name' => 'Conector de Carga Lightning',
                'description' => 'Flex de carga iPhone',
                'price' => 80.00,
                'stock' => 20,
                'category' => 'peça',
                'created_at' => Carbon::create(2025, 1, 3, 12, 30),
            ],
            [
                'name' => 'Alto Falante iPhone',
                'description' => 'Speaker inferior para iPhone',
                'price' => 60.00,
                'stock' => 12,
                'category' => 'peça',
                'created_at' => Carbon::create(2025, 1, 3, 13, 0),
            ],
            [
                'name' => 'Câmera Traseira Samsung A32',
                'description' => 'Câmera principal 64MP',
                'price' => 180.00,
                'stock' => 8,
                'category' => 'peça',
                'created_at' => Carbon::create(2025, 1, 3, 13, 30),
            ],
        ];

        foreach ($products as $data) {
            Product::create($data);
        }
    }
}
