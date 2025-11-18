<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\ServiceOrder;
use Carbon\Carbon;

class FullYearSeeder extends Seeder
{
    public function run(): void
    {
        // Obter clientes e produtos existentes
        $customers = Customer::all();
        $products = Product::all();

        if ($customers->isEmpty() || $products->isEmpty()) {
            $this->command->error('Execute o DatabaseSeeder primeiro para criar clientes e produtos!');
            return;
        }

        $statuses = ['pending', 'approved', 'in_progress', 'completed', 'cancelled'];
        $paymentMethods = ['dinheiro', 'cartao_debito', 'cartao_credito', 'pix'];

        // Gerar dados para cada mês de 2025
        for ($month = 1; $month <= 11; $month++) {
            $this->command->info("Gerando dados para mês $month/2025...");

            // Número de transações por mês (variável para simular flutuações)
            $salesCount = rand(15, 35);
            $ordersCount = rand(10, 25);

            // VENDAS
            for ($i = 0; $i < $salesCount; $i++) {
                // Data aleatória dentro do mês
                $day = rand(1, Carbon::create(2025, $month, 1)->daysInMonth);
                $hour = rand(8, 20);
                $minute = rand(0, 59);
                $saleDate = Carbon::create(2025, $month, $day, $hour, $minute);

                // Selecionar produtos aleatórios (1 a 4 produtos)
                $itemCount = rand(1, 4);
                $selectedProducts = $products->random(min($itemCount, $products->count()));
                
                $subtotal = 0;
                $items = [];
                
                foreach ($selectedProducts as $product) {
                    $quantity = rand(1, 3);
                    $unitPrice = $product->price;
                    $itemSubtotal = $quantity * $unitPrice;
                    $subtotal += $itemSubtotal;
                    
                    $items[] = [
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'subtotal' => $itemSubtotal,
                    ];
                }

                // Aplicar desconto em 30% das vendas
                $hasDiscount = rand(1, 100) <= 30;
                $discountPercentage = 0;
                $discountAmount = 0;
                
                if ($hasDiscount) {
                    if (rand(0, 1)) {
                        // Desconto por percentual (5% a 20%)
                        $discountPercentage = rand(5, 20);
                        $discountAmount = ($subtotal * $discountPercentage) / 100;
                    } else {
                        // Desconto por valor fixo (R$ 5 a R$ 50)
                        $discountAmount = rand(5, min(50, $subtotal * 0.5));
                        $discountPercentage = ($discountAmount / $subtotal) * 100;
                    }
                }

                $total = $subtotal - $discountAmount;

                // Criar venda
                $sale = Sale::create([
                    'customer_id' => rand(0, 1) ? $customers->random()->id : null,
                    'subtotal' => $subtotal,
                    'discount_percentage' => round($discountPercentage, 2),
                    'discount_amount' => round($discountAmount, 2),
                    'total' => round($total, 2),
                    'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                    'notes' => $hasDiscount ? 'Desconto aplicado' : null,
                    'created_at' => $saleDate,
                    'updated_at' => $saleDate,
                ]);

                // Criar itens da venda
                foreach ($items as $item) {
                    $sale->items()->create($item);
                }
            }

            // ORDENS DE SERVIÇO
            for ($i = 0; $i < $ordersCount; $i++) {
                // Data aleatória dentro do mês
                $day = rand(1, Carbon::create(2025, $month, 1)->daysInMonth);
                $hour = rand(8, 20);
                $minute = rand(0, 59);
                $orderDate = Carbon::create(2025, $month, $day, $hour, $minute);

                // Status aleatório com maior probabilidade de completed
                $statusWeights = [
                    'pending' => 5,
                    'approved' => 10,
                    'in_progress' => 15,
                    'completed' => 60,  // 60% concluídas
                    'cancelled' => 10,
                ];
                
                $statusPool = [];
                foreach ($statusWeights as $status => $weight) {
                    $statusPool = array_merge($statusPool, array_fill(0, $weight, $status));
                }
                $selectedStatus = $statusPool[array_rand($statusPool)];

                // Modelos de celulares comuns
                $devices = [
                    'iPhone 13', 'iPhone 14', 'iPhone 15', 'Samsung Galaxy S23',
                    'Samsung Galaxy S24', 'Xiaomi Redmi Note 12', 'Motorola Edge 40',
                    'Samsung A54', 'iPhone 12', 'Xiaomi Mi 11', 'Realme GT',
                ];

                // Problemas comuns
                $problems = [
                    'Tela quebrada',
                    'Bateria viciada, não segura carga',
                    'Não carrega, conector com defeito',
                    'Câmera traseira não funciona',
                    'Sem sinal, antena com problema',
                    'Alto-falante sem som',
                    'Botão power não responde',
                    'Touch screen não funciona',
                    'Molhou, não liga',
                    'Travando muito, lentidão',
                ];

                $device = $devices[array_rand($devices)];
                $problem = $problems[array_rand($problems)];
                $price = rand(80, 500);

                // Data de atualização (para completed, alguns dias depois)
                $updatedAt = $selectedStatus === 'completed' 
                    ? $orderDate->copy()->addDays(rand(1, 7))
                    : $orderDate;

                ServiceOrder::create([
                    'customer_id' => $customers->random()->id,
                    'device_model' => $device,
                    'device_imei' => rand(100000000000000, 999999999999999),
                    'problem_description' => $problem,
                    'price' => $price,
                    'diagnostic' => $selectedStatus !== 'pending' ? $problem : null,
                    'estimated_cost' => $selectedStatus !== 'pending' ? $price : null,
                    'final_cost' => $selectedStatus === 'completed' ? rand($price - 20, $price + 20) : null,
                    'status' => $selectedStatus,
                    'deadline' => $orderDate->copy()->addDays(rand(3, 15)),
                    'notes' => null,
                    'created_at' => $orderDate,
                    'updated_at' => $updatedAt,
                ]);
            }
        }

        $this->command->info('✅ Dados do ano completo gerados com sucesso!');
        $this->command->info('📊 Total aproximado: ' . ($salesCount * 11) . ' vendas e ' . ($ordersCount * 11) . ' ordens de serviço');
    }
}
