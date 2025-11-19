<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use Carbon\Carbon;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        // Remove todos os registros mantendo auto-increment
        Customer::query()->delete();

        $customers = [
            [
                'name' => 'João Silva',
                'phone' => '(11) 98765-4321',
                'email' => 'joao.silva@email.com',
                'address' => 'Rua das Flores, 123 - São Paulo, SP',
                'created_at' => Carbon::create(2025, 1, 5, 10, 0),
            ],
            [
                'name' => 'Maria Santos',
                'phone' => '(11) 97654-3210',
                'email' => 'maria.santos@email.com',
                'address' => 'Av. Paulista, 456 - São Paulo, SP',
                'created_at' => Carbon::create(2025, 1, 12, 14, 30),
            ],
            [
                'name' => 'Pedro Oliveira',
                'phone' => '(11) 96543-2109',
                'email' => 'pedro.oliveira@email.com',
                'address' => 'Rua Augusta, 789 - São Paulo, SP',
                'created_at' => Carbon::create(2025, 1, 20, 9, 15),
            ],
            [
                'name' => 'Ana Costa',
                'phone' => '(11) 95432-1098',
                'email' => 'ana.costa@email.com',
                'address' => 'Rua da Consolação, 321 - São Paulo, SP',
                'created_at' => Carbon::create(2025, 2, 3, 16, 20),
            ],
            [
                'name' => 'Carlos Mendes',
                'phone' => '(11) 94321-0987',
                'email' => 'carlos.mendes@email.com',
                'address' => 'Av. Rebouças, 654 - São Paulo, SP',
                'created_at' => Carbon::create(2025, 2, 15, 11, 45),
            ],
            [
                'name' => 'Juliana Ferreira',
                'phone' => '(11) 93210-9876',
                'email' => 'juliana.ferreira@email.com',
                'address' => 'Rua Vergueiro, 987 - São Paulo, SP',
                'created_at' => Carbon::create(2025, 3, 8, 13, 30),
            ],
            [
                'name' => 'Roberto Alves',
                'phone' => '(11) 92109-8765',
                'email' => 'roberto.alves@email.com',
                'address' => 'Rua Oscar Freire, 159 - São Paulo, SP',
                'created_at' => Carbon::create(2025, 3, 22, 10, 10),
            ],
            [
                'name' => 'Fernanda Lima',
                'phone' => '(11) 91098-7654',
                'email' => 'fernanda.lima@email.com',
                'address' => 'Av. Faria Lima, 753 - São Paulo, SP',
                'created_at' => Carbon::create(2025, 4, 5, 15, 0),
            ],
            [
                'name' => 'Lucas Rodrigues',
                'phone' => '(11) 90987-6543',
                'email' => 'lucas.rodrigues@email.com',
                'address' => 'Rua Haddock Lobo, 456 - São Paulo, SP',
                'created_at' => Carbon::create(2025, 4, 18, 9, 30),
            ],
            [
                'name' => 'Patrícia Sousa',
                'phone' => '(11) 99876-5432',
                'email' => 'patricia.sousa@email.com',
                'address' => 'Alameda Santos, 258 - São Paulo, SP',
                'created_at' => Carbon::create(2025, 5, 10, 14, 15),
            ],
            [
                'name' => 'Ricardo Barbosa',
                'phone' => '(11) 98765-4320',
                'email' => 'ricardo.barbosa@email.com',
                'address' => 'Rua Estados Unidos, 147 - São Paulo, SP',
                'created_at' => Carbon::create(2025, 5, 25, 11, 0),
            ],
            [
                'name' => 'Camila Martins',
                'phone' => '(11) 97654-3209',
                'email' => 'camila.martins@email.com',
                'address' => 'Av. Brasil, 852 - São Paulo, SP',
                'created_at' => Carbon::create(2025, 6, 7, 16, 45),
            ],
            [
                'name' => 'Bruno Cardoso',
                'phone' => '(11) 96543-2108',
                'email' => 'bruno.cardoso@email.com',
                'address' => 'Rua Pamplona, 369 - São Paulo, SP',
                'created_at' => Carbon::create(2025, 6, 20, 10, 30),
            ],
            [
                'name' => 'Larissa Gomes',
                'phone' => '(11) 95432-1097',
                'email' => 'larissa.gomes@email.com',
                'address' => 'Rua Bela Cintra, 741 - São Paulo, SP',
                'created_at' => Carbon::create(2025, 7, 12, 13, 20),
            ],
            [
                'name' => 'Gustavo Pereira',
                'phone' => '(11) 94321-0986',
                'email' => 'gustavo.pereira@email.com',
                'address' => 'Av. Ibirapuera, 963 - São Paulo, SP',
                'created_at' => Carbon::create(2025, 7, 28, 15, 50),
            ],
            [
                'name' => 'Aline Ribeiro',
                'phone' => '(11) 93210-9875',
                'email' => 'aline.ribeiro@email.com',
                'address' => 'Rua Iguatemi, 258 - São Paulo, SP',
                'created_at' => Carbon::create(2025, 8, 9, 9, 40),
            ],
            [
                'name' => 'Marcos Vieira',
                'phone' => '(11) 92109-8764',
                'email' => 'marcos.vieira@email.com',
                'address' => 'Av. São João, 456 - São Paulo, SP',
                'created_at' => Carbon::create(2025, 8, 23, 14, 10),
            ],
            [
                'name' => 'Tatiana Castro',
                'phone' => '(11) 91098-7653',
                'email' => 'tatiana.castro@email.com',
                'address' => 'Rua da Glória, 159 - São Paulo, SP',
                'created_at' => Carbon::create(2025, 9, 5, 11, 25),
            ],
            [
                'name' => 'Felipe Araujo',
                'phone' => '(11) 90987-6542',
                'email' => 'felipe.araujo@email.com',
                'address' => 'Av. Angélica, 753 - São Paulo, SP',
                'created_at' => Carbon::create(2025, 9, 18, 16, 0),
            ],
            [
                'name' => 'Vanessa Dias',
                'phone' => '(11) 99876-5431',
                'email' => 'vanessa.dias@email.com',
                'address' => 'Rua Cardeal Arcoverde, 357 - São Paulo, SP',
                'created_at' => Carbon::create(2025, 10, 8, 10, 15),
            ],
        ];

        foreach ($customers as $data) {
            Customer::create($data);
        }
    }
}
