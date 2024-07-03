<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('company')->insert([
            [
                'city' => 'Santa Fé Do Sul',
                'cnpj' => '1234567891234',
                'localization' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d530.5345260526332!2d-50.92700978807556!3d-20.206018977885375!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9499c6b2f73b49d7%3A0x3eaffb81249046e6!2sBarbearia%20Marianos!5e0!3m2!1spt-BR!2sbr!4v1718453917550!5m2!1spt-BR!2sbr" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                'name' => 'Barbearia Mariano',
                'neighborhood' => 'Centro',
                'road' => 'Avenida Navarro de Andrade',
                'number' => '1005',
                'state' => 'São Paulo',
                'zipCode' => '15775000',
                'token' => 'fee0bdf87366430b6302536ca9f84772305b5cef15859ac9e5...',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
