<?php

namespace Database\Seeders;

use App\Models\ProcedimentoOdontologico;
use Illuminate\Database\Seeder;

class ProcedimentoOdontologicoSeeder extends Seeder
{
    public function run(): void
    {
        $procedimentos = [
            [
                'nome' => 'Limpeza',
                'codigo' => 'LIM',
                'descricao' => 'Remoção de placa bacteriana e tártaro.',
                'duracao' => 40
            ],
            [
                'nome' => 'Tratamento de Canal',
                'codigo' => 'CAN',
                'descricao' => 'Tratamento endodôntico.',
                'duracao' => 90
            ],
            [
                'nome' => 'Obturação',
                'codigo' => 'OBT',
                'descricao' => 'Restauração de dente com material restaurador.',
                'duracao' => 60
            ],
            [
                'nome' => 'Extração',
                'codigo' => 'EXT',
                'descricao' => 'Remoção cirúrgica ou simples do dente.',
                'duracao' => 45
            ],
            [
                'nome' => 'Implante',
                'codigo' => 'IMP',
                'descricao' => 'Instalação de implante dentário.',
                'duracao' => 120
            ],
            [
                'nome' => 'Prótese',
                'codigo' => 'PRO',
                'descricao' => 'Confecção ou instalação de prótese.',
                'duracao' => 120
            ],
            [
                'nome' => 'Cirurgia',
                'codigo' => 'CIR',
                'descricao' => 'Procedimento cirúrgico odontológico.',
                'duracao' => 90
            ]
        ];

        foreach ($procedimentos as $procedimento) {
            ProcedimentoOdontologico::create(
                $procedimento
            );
        }
    }
}
