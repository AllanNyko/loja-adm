<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale;
use Carbon\Carbon;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        // Remove todos os registros mantendo auto-increment
        Sale::query()->delete();

        $this->createMonthlySales();
    }

    private function createMonthlySales()
    {
        // Pega os IDs reais dos clientes
        $customerIds = \App\Models\Customer::pluck('id')->toArray();

        // Criar vendas para cada mês de 2025
        for ($month = 1; $month <= 12; $month++) {
            $date = Carbon::create(2025, $month, 1);
            $salesInMonth = rand(30, 60); // Entre 30 e 60 vendas por mês

            for ($i = 0; $i < $salesInMonth; $i++) {
                // Total aleatório entre R$ 15 e R$ 500
                $total = rand(15, 500) + (rand(0, 99) / 100);
                
                // Define método de pagamento
                $paymentMethod = $this->getRandomPaymentMethod();
                
                // Data da venda
                $dayCreated = rand(1, 28);
                $createdAt = $date->copy()->day($dayCreated)->hour(rand(9, 19))->minute(rand(0, 59));

                // 60% das vendas têm cliente cadastrado
                $customerId = (rand(1, 100) <= 60) ? $customerIds[array_rand($customerIds)] : null;

                Sale::create([
                    'customer_id' => $customerId,
                    'total' => $total,
                    'payment_method' => $paymentMethod,
                    'notes' => $this->generateNotes(),
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }
        }
    }

    private function getQuantityByProduct($productId)
    {
        // Produtos baratos: mais quantidade
        // Produtos caros: menos quantidade
        if ($productId <= 10) { // Acessórios
            return rand(1, 3);
        } else { // Peças
            return 1;
        }
    }

    private function getPriceByProduct($productId)
    {
        // Preços aproximados baseados no ID
        $prices = [
            1 => 25.90,  // Película
            2 => 19.90,  // Capa Silicone
            3 => 35.90,  // Capa Carteira
            4 => 45.00,  // Carregador Type-C
            5 => 15.90,  // Cabo USB-C
            6 => 35.00,  // Cabo Lightning
            7 => 89.90,  // Fone Bluetooth
            8 => 25.00,  // Fone com Fio
            9 => 39.90,  // Suporte Veicular
            10 => 12.90, // Pop Socket
            11 => 350.00, // Display iPhone 11
            12 => 450.00, // Display iPhone 12
            13 => 280.00, // Display Samsung A32
            14 => 150.00, // Bateria iPhone 11
            15 => 120.00, // Bateria Samsung A32
            16 => 110.00, // Bateria Motorola G9
            17 => 45.00,  // Conector USB-C
            18 => 80.00,  // Conector Lightning
            19 => 60.00,  // Alto Falante
            20 => 180.00, // Câmera Samsung
        ];

        return $prices[$productId] ?? 50.00;
    }

    private function getRandomPaymentMethod()
    {
        $methods = ['dinheiro', 'cartao_credito', 'cartao_debito', 'pix'];
        $weights = [20, 35, 25, 20]; // Probabilidade de cada método
        
        $rand = rand(1, 100);
        $sum = 0;
        
        foreach ($weights as $index => $weight) {
            $sum += $weight;
            if ($rand <= $sum) {
                return $methods[$index];
            }
        }
        
        return 'dinheiro';
    }

    private function generateNotes()
    {
        // 30% das vendas têm notas
        if (rand(1, 100) <= 30) {
            $notes = [
                'Cliente solicitou nota fiscal',
                'Venda com desconto promocional',
                'Cliente fidelizado',
                'Combo promocional',
                'Pagamento parcelado',
            ];
            return $notes[array_rand($notes)];
        }

        return null;
    }
}
