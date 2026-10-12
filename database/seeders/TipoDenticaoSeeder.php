<?php

namespace Database\Seeders;

use App\Models\TipoDenticao;
use Illuminate\Database\Seeder;

class TipoDenticaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoDenticao::insert([
            [
                'nome' => 'Dentição Decídua',
                'idade_inicial' => 0,
                'idade_final' => 5,
                'descricao' => 'Dentes de leite',
                'ativo' => true
            ],

            [
                'nome' => 'Dentição Mista',
                'idade_inicial' => 6,
                'idade_final' => 12,
                'descricao' => 'Transição',
                'ativo' => true
            ],

            [
                'nome' => 'Dentição Permanente',
                'idade_inicial' => 13,
                'idade_final' => 120,
                'descricao' => 'Adultos',
                'ativo' => true
            ]

        ]);
    }
}
