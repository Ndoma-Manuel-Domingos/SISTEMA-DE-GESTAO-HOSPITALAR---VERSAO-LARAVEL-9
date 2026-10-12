<?php

namespace Database\Seeders;

use App\Models\EstadoDente;
use Illuminate\Database\Seeder;

class EstadoDenteSeeder extends Seeder
{
    public function run(): void
    {
        $estados = [
            [
                'nome' => 'Saudável',
                'cor' => '#28a745',
                'icone' => 'fas fa-check'
            ],
            [
                'nome' => 'Cárie',
                'cor' => '#dc3545',
                'icone' => 'fas fa-exclamation'
            ],
            [
                'nome' => 'Extraído',
                'cor' => '#000000',
                'icone' => 'fas fa-times'
            ],
            [
                'nome' => 'Implante',
                'cor' => '#6f42c1',
                'icone' => 'fas fa-screwdriver'
            ],
            [
                'nome' => 'Canal',
                'cor' => '#007bff',
                'icone' => 'fas fa-wave-square'
            ],
            [
                'nome' => 'Fratura',
                'cor' => '#fd7e14',
                'icone' => 'fas fa-bolt'
            ],
            [
                'nome' => 'Restauração',
                'cor' => '#ffc107',
                'icone' => 'fas fa-fill-drip'
            ],
            [
                'nome' => 'Ausente',
                'cor' => '#343a40',
                'icone' => 'fas fa-ban'
            ],
            [
                'nome' => 'Prótese',
                'cor' => '#17a2b8',
                'icone' => 'fas fa-tooth'
            ],
            [
                'nome' => 'Mobilidade',
                'cor' => '#6610f2',
                'icone' => 'fas fa-arrows-alt'
            ],
            [
                'nome' => 'Tártaro',
                'cor' => '#795548',
                'icone' => 'fas fa-layer-group'
            ]
        ];
        foreach ($estados as $estado) {
            EstadoDente::create($estado);
        }
    }
}
