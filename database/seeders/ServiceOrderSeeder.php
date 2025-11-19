<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceOrder;
use Carbon\Carbon;

class ServiceOrderSeeder extends Seeder
{
    public function run(): void
    {
        // Remove todos os registros mantendo auto-increment
        ServiceOrder::query()->delete();

        $this->createMonthlyOrders();
    }

    private function createMonthlyOrders()
    {
        $deviceModels = [
            'iPhone 11', 'iPhone 12', 'iPhone 13', 'iPhone SE',
            'Samsung Galaxy A32', 'Samsung Galaxy A52', 'Samsung Galaxy S21',
            'Motorola G9 Plus', 'Motorola G20', 'Xiaomi Redmi Note 10',
            'Xiaomi Redmi 9', 'LG K52', 'Nokia G20'
        ];

        $problems = [
            'Tela trincada após queda' => 'Necessário trocar display completo',
            'Não carrega' => 'Conector de carga danificado',
            'Bateria viciada' => 'Substituição da bateria recomendada',
            'Não liga' => 'Problema na placa mãe - orçamento necessário',
            'Molhou' => 'Oxidação nos componentes - limpeza e teste',
            'Tela não responde ao toque' => 'Touch screen com defeito',
            'Sem áudio no alto-falante' => 'Alto-falante queimado',
            'Câmera embaçada' => 'Lente da câmera com infiltração',
            'Botão power travado' => 'Flex do botão power com defeito',
            'Não pega sinal' => 'Antena ou placa com problema',
        ];

        // Pega os IDs reais dos clientes
        $customerIds = \App\Models\Customer::pluck('id')->toArray();
        $orderNumber = 1;

        // Criar ordens para cada mês de 2025
        for ($month = 1; $month <= 12; $month++) {
            $date = Carbon::create(2025, $month, 1);
            $ordersInMonth = rand(8, 15); // Entre 8 e 15 ordens por mês

            for ($i = 0; $i < $ordersInMonth; $i++) {
                $problem = array_rand($problems);
                $diagnostic = $problems[$problem];
                $device = $deviceModels[array_rand($deviceModels)];
                
                // Preços baseados no tipo de problema
                $price = $this->calculatePrice($problem);
                
                // Define status baseado no mês (mês atual e futuro têm ordens em andamento)
                $currentMonth = Carbon::now()->month;
                $status = $this->defineStatus($month, $currentMonth);
                
                // Datas baseadas no status
                $dayCreated = rand(1, 28);
                $createdAt = $date->copy()->day($dayCreated)->hour(rand(9, 18))->minute(rand(0, 59));
                
                $finalCost = null;
                $updatedAt = $createdAt;
                
                if ($status === 'completed') {
                    $updatedAt = $createdAt->copy()->addDays(rand(2, 7));
                    $finalCost = $price + rand(-20, 30); // Variação no custo final
                } elseif ($status === 'cancelled') {
                    $updatedAt = $createdAt->copy()->addDays(rand(1, 3));
                    $finalCost = 0;
                }

                ServiceOrder::create([
                    'customer_id' => $customerIds[array_rand($customerIds)],
                    'device_model' => $device,
                    'device_imei' => $this->generateImei(),
                    'problem_description' => $problem,
                    'price' => $price,
                    'diagnostic' => $diagnostic,
                    'estimated_cost' => $price,
                    'final_cost' => $finalCost,
                    'status' => $status,
                    'notes' => $this->generateNotes($status),
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt,
                ]);

                $orderNumber++;
            }
        }
    }

    private function calculatePrice($problem)
    {
        $prices = [
            'Tela trincada após queda' => rand(280, 450),
            'Não carrega' => rand(80, 120),
            'Bateria viciada' => rand(120, 180),
            'Não liga' => rand(150, 300),
            'Molhou' => rand(100, 250),
            'Tela não responde ao toque' => rand(280, 450),
            'Sem áudio no alto-falante' => rand(60, 100),
            'Câmera embaçada' => rand(150, 250),
            'Botão power travado' => rand(80, 150),
            'Não pega sinal' => rand(120, 200),
        ];

        return $prices[$problem] ?? 150;
    }

    private function defineStatus($month, $currentMonth)
    {
        if ($month < $currentMonth) {
            // Meses passados: 80% concluídos, 15% cancelados, 5% em andamento
            $rand = rand(1, 100);
            if ($rand <= 80) return 'completed';
            if ($rand <= 95) return 'cancelled';
            return 'in_progress';
        } elseif ($month == $currentMonth) {
            // Mês atual: mix de status
            $rand = rand(1, 100);
            if ($rand <= 40) return 'completed';
            if ($rand <= 50) return 'cancelled';
            if ($rand <= 75) return 'in_progress';
            if ($rand <= 90) return 'approved';
            return 'pending';
        } else {
            // Meses futuros: apenas pendentes
            return 'pending';
        }
    }

    private function generateImei()
    {
        return sprintf(
            '%03d%03d%03d%03d%03d',
            rand(100, 999),
            rand(100, 999),
            rand(100, 999),
            rand(100, 999),
            rand(100, 999)
        );
    }

    private function generateNotes($status)
    {
        $notes = [
            'completed' => [
                'Cliente satisfeito com o serviço',
                'Reparo concluído conforme combinado',
                'Teste realizado - funcionando perfeitamente',
                null,
            ],
            'cancelled' => [
                'Cliente desistiu do reparo',
                'Custo acima do esperado pelo cliente',
                'Cliente optou por comprar aparelho novo',
            ],
            'in_progress' => [
                'Aguardando peça do fornecedor',
                'Em reparo',
                'Teste em andamento',
            ],
            'approved' => [
                'Orçamento aprovado - iniciando reparo',
                'Cliente confirmou o serviço',
            ],
            'pending' => [
                'Aguardando análise técnica',
                null,
            ],
        ];

        $statusNotes = $notes[$status] ?? [null];
        return $statusNotes[array_rand($statusNotes)];
    }
}
