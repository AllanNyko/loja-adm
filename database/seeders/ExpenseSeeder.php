<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Expense;
use Carbon\Carbon;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Remove todos os registros mantendo auto-increment
        Expense::query()->delete();

        // Popula despesas para todos os meses de 2025
        for ($month = 1; $month <= 12; $month++) {
            $this->createMonthExpenses($month, 2025);
        }
    }

    private function createMonthExpenses($month, $year)
    {
        $date = Carbon::create($year, $month, 1);
        $monthName = $date->translatedFormat('F');
        
        // Despesas fixas mensais
        $fixedExpenses = [
            [
                'description' => "Aluguel - {$monthName} {$year}",
                'category' => 'rent',
                'amount' => 2500.00,
                'due_date' => $date->copy()->day(5),
                'paid_date' => $date->copy()->day(5),
                'status' => 'paid',
                'payment_method' => 'bank_transfer',
                'notes' => 'Aluguel da loja',
                'created_at' => $date->copy()->day(1)->hour(8),
                'updated_at' => $date->copy()->day(5)->hour(14),
            ],
            [
                'description' => "Conta de Luz - {$monthName} {$year}",
                'category' => 'utilities',
                'amount' => rand(350, 550) + (rand(0, 99) / 100),
                'due_date' => $date->copy()->day(10),
                'paid_date' => $date->copy()->day(9),
                'status' => 'paid',
                'payment_method' => 'pix',
                'notes' => 'Consumo de energia elétrica',
                'created_at' => $date->copy()->day(3)->hour(10),
                'updated_at' => $date->copy()->day(9)->hour(16),
            ],
            [
                'description' => "Internet Fibra - {$monthName} {$year}",
                'category' => 'internet',
                'amount' => 129.90,
                'due_date' => $date->copy()->day(15),
                'paid_date' => $date->copy()->day(15),
                'status' => 'paid',
                'payment_method' => 'bank_transfer',
                'notes' => 'Plano 300MB',
                'created_at' => $date->copy()->day(8)->hour(9),
                'updated_at' => $date->copy()->day(15)->hour(11),
            ],
            [
                'description' => "Telefone Fixo - {$monthName} {$year}",
                'category' => 'internet',
                'amount' => 89.90,
                'due_date' => $date->copy()->day(20),
                'paid_date' => $date->copy()->day(19),
                'status' => 'paid',
                'payment_method' => 'debit_card',
                'notes' => 'Linha telefônica comercial',
                'created_at' => $date->copy()->day(12)->hour(14),
                'updated_at' => $date->copy()->day(19)->hour(10),
            ],
        ];

        // Despesas variáveis (não ocorrem todos os meses)
        $variableExpenses = [];

        // Insumos (a cada 2 meses)
        if ($month % 2 == 1) {
            $variableExpenses[] = [
                'description' => "Materiais de Manutenção - {$monthName} {$year}",
                'category' => 'supplies',
                'amount' => rand(200, 800) + (rand(0, 99) / 100),
                'due_date' => $date->copy()->day(12),
                'paid_date' => $date->copy()->day(12),
                'status' => 'paid',
                'payment_method' => 'credit_card',
                'notes' => 'Peças e ferramentas para reparos',
                'created_at' => $date->copy()->day(8)->hour(15),
                'updated_at' => $date->copy()->day(12)->hour(17),
            ];
        }

        // Marketing (trimestral)
        if (in_array($month, [3, 6, 9, 12])) {
            $variableExpenses[] = [
                'description' => "Marketing Digital - Trimestre {$monthName} {$year}",
                'category' => 'marketing',
                'amount' => rand(300, 600) + (rand(0, 99) / 100),
                'due_date' => $date->copy()->day(25),
                'paid_date' => $date->copy()->day(25),
                'status' => 'paid',
                'payment_method' => 'credit_card',
                'notes' => 'Anúncios Facebook/Instagram',
                'created_at' => $date->copy()->day(20)->hour(9),
                'updated_at' => $date->copy()->day(25)->hour(14),
            ];
        }

        // Manutenção (esporádica)
        if (in_array($month, [2, 5, 8, 11])) {
            $variableExpenses[] = [
                'description' => "Manutenção de Equipamentos - {$monthName} {$year}",
                'category' => 'maintenance',
                'amount' => rand(150, 400) + (rand(0, 99) / 100),
                'due_date' => $date->copy()->day(18),
                'paid_date' => $date->copy()->day(18),
                'status' => 'paid',
                'payment_method' => 'cash',
                'notes' => 'Manutenção preventiva de ferramentas',
                'created_at' => $date->copy()->day(15)->hour(11),
                'updated_at' => $date->copy()->day(18)->hour(16),
            ];
        }

        // Equipamentos (anual - apenas em janeiro)
        if ($month == 1) {
            $variableExpenses[] = [
                'description' => "Compra de Equipamentos - {$year}",
                'category' => 'equipment',
                'amount' => 3500.00,
                'due_date' => $date->copy()->day(15),
                'paid_date' => $date->copy()->day(15),
                'status' => 'paid',
                'payment_method' => 'credit_card',
                'notes' => 'Novos equipamentos de teste e reparo',
                'created_at' => $date->copy()->day(10)->hour(10),
                'updated_at' => $date->copy()->day(15)->hour(15),
            ];
        }

        // Impostos (mensal)
        $variableExpenses[] = [
            'description' => "DAS MEI - {$monthName} {$year}",
            'category' => 'taxes',
            'amount' => 70.60,
            'due_date' => $date->copy()->day(20),
            'paid_date' => $date->copy()->day(20),
            'status' => 'paid',
            'payment_method' => 'bank_transfer',
            'notes' => 'Pagamento do Simples Nacional',
            'created_at' => $date->copy()->day(1)->hour(9),
            'updated_at' => $date->copy()->day(20)->hour(13),
        ];

        // Salários (apenas se não for janeiro - primeiro mês)
        if ($month > 1) {
            $variableExpenses[] = [
                'description' => "Salário Funcionário - {$monthName} {$year}",
                'category' => 'salary',
                'amount' => 1800.00,
                'due_date' => $date->copy()->day(5),
                'paid_date' => $date->copy()->day(5),
                'status' => 'paid',
                'payment_method' => 'bank_transfer',
                'notes' => 'Pagamento mensal',
                'created_at' => $date->copy()->day(1)->hour(8),
                'updated_at' => $date->copy()->day(5)->hour(9),
            ];
        }

        // Outras despesas eventuais
        if (rand(1, 3) == 1) { // 33% de chance
            $randomDay = rand(5, 25);
            $variableExpenses[] = [
                'description' => "Despesas Diversas - {$monthName} {$year}",
                'category' => 'other',
                'amount' => rand(50, 200) + (rand(0, 99) / 100),
                'due_date' => $date->copy()->day($randomDay),
                'paid_date' => $date->copy()->day($randomDay),
                'status' => 'paid',
                'payment_method' => ['cash', 'pix', 'debit_card'][rand(0, 2)],
                'notes' => 'Gastos eventuais',
                'created_at' => $date->copy()->day($randomDay - 2)->hour(10),
                'updated_at' => $date->copy()->day($randomDay)->hour(14),
            ];
        }

        // Adiciona algumas despesas pendentes para o mês atual e futuro
        $currentMonth = Carbon::now()->month;
        if ($month >= $currentMonth) {
            // Despesa vencida (apenas no mês atual)
            if ($month == $currentMonth) {
                $overdueDate = Carbon::now()->subDays(5);
                $variableExpenses[] = [
                    'description' => "Fornecedor de Peças - {$monthName} {$year}",
                    'category' => 'supplies',
                    'amount' => rand(500, 1000) + (rand(0, 99) / 100),
                    'due_date' => $overdueDate,
                    'paid_date' => null,
                    'status' => 'overdue',
                    'payment_method' => null,
                    'notes' => 'Pagamento atrasado',
                    'created_at' => $overdueDate->copy()->subDays(10),
                    'updated_at' => $overdueDate->copy()->subDays(10),
                ];
            }

            // Despesa pendente
            $variableExpenses[] = [
                'description' => "IPTU - Parcela {$month}",
                'category' => 'taxes',
                'amount' => 180.50,
                'due_date' => $date->copy()->day(28),
                'paid_date' => null,
                'status' => 'pending',
                'payment_method' => null,
                'notes' => 'IPTU parcelado',
                'created_at' => $date->copy()->day(1)->hour(8),
                'updated_at' => $date->copy()->day(1)->hour(8),
            ];
        }

        // Combina todas as despesas
        $allExpenses = array_merge($fixedExpenses, $variableExpenses);

        // Cria as despesas no banco
        foreach ($allExpenses as $expense) {
            Expense::create($expense);
        }
    }
}
