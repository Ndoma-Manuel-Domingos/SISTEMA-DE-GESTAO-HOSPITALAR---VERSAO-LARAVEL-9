<?php

namespace Database\Seeders;

use App\Models\Dente;
use Illuminate\Database\Seeder;

class DenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $dentes = [

            // Quadrante 1 - Superior Direito
            [
                'codigo_fdi' => '11',
                'nome' => 'Incisivo Central Superior Direito',
                'quadrante' => 'Q1',
                'arcada' => 'Superior',
                'lado' => 'Direito',
                'ordem' => 1,
                'svg_id' => 'tooth11',
            ],
            [
                'codigo_fdi' => '12',
                'nome' => 'Incisivo Lateral Superior Direito',
                'quadrante' => 'Q1',
                'arcada' => 'Superior',
                'lado' => 'Direito',
                'ordem' => 2,
                'svg_id' => 'tooth12',
            ],
            [
                'codigo_fdi' => '13',
                'nome' => 'Canino Superior Direito',
                'quadrante' => 'Q1',
                'arcada' => 'Superior',
                'lado' => 'Direito',
                'ordem' => 3,
                'svg_id' => 'tooth13',
            ],
            [
                'codigo_fdi' => '14',
                'nome' => 'Primeiro Pré-Molar Superior Direito',
                'quadrante' => 'Q1',
                'arcada' => 'Superior',
                'lado' => 'Direito',
                'ordem' => 4,
                'svg_id' => 'tooth14',
            ],
            [
                'codigo_fdi' => '15',
                'nome' => 'Segundo Pré-Molar Superior Direito',
                'quadrante' => 'Q1',
                'arcada' => 'Superior',
                'lado' => 'Direito',
                'ordem' => 5,
                'svg_id' => 'tooth15',
            ],
            [
                'codigo_fdi' => '16',
                'nome' => 'Primeiro Molar Superior Direito',
                'quadrante' => 'Q1',
                'arcada' => 'Superior',
                'lado' => 'Direito',
                'ordem' => 6,
                'svg_id' => 'tooth16',
            ],
            [
                'codigo_fdi' => '17',
                'nome' => 'Segundo Molar Superior Direito',
                'quadrante' => 'Q1',
                'arcada' => 'Superior',
                'lado' => 'Direito',
                'ordem' => 7,
                'svg_id' => 'tooth17',
            ],
            [
                'codigo_fdi' => '18',
                'nome' => 'Terceiro Molar Superior Direito',
                'quadrante' => 'Q1',
                'arcada' => 'Superior',
                'lado' => 'Direito',
                'ordem' => 8,
                'svg_id' => 'tooth18',
            ],

            // Quadrante 2 - Superior Esquerdo
            [
                'codigo_fdi' => '21',
                'nome' => 'Incisivo Central Superior Esquerdo',
                'quadrante' => 'Q2',
                'arcada' => 'Superior',
                'lado' => 'Esquerdo',
                'ordem' => 1,
                'svg_id' => 'tooth21',
            ],
            [
                'codigo_fdi' => '22',
                'nome' => 'Incisivo Lateral Superior Esquerdo',
                'quadrante' => 'Q2',
                'arcada' => 'Superior',
                'lado' => 'Esquerdo',
                'ordem' => 2,
                'svg_id' => 'tooth22',
            ],
            [
                'codigo_fdi' => '23',
                'nome' => 'Canino Superior Esquerdo',
                'quadrante' => 'Q2',
                'arcada' => 'Superior',
                'lado' => 'Esquerdo',
                'ordem' => 3,
                'svg_id' => 'tooth23',
            ],
            [
                'codigo_fdi' => '24',
                'nome' => 'Primeiro Pré-Molar Superior Esquerdo',
                'quadrante' => 'Q2',
                'arcada' => 'Superior',
                'lado' => 'Esquerdo',
                'ordem' => 4,
                'svg_id' => 'tooth24',
            ],
            [
                'codigo_fdi' => '25',
                'nome' => 'Segundo Pré-Molar Superior Esquerdo',
                'quadrante' => 'Q2',
                'arcada' => 'Superior',
                'lado' => 'Esquerdo',
                'ordem' => 5,
                'svg_id' => 'tooth25',
            ],
            [
                'codigo_fdi' => '26',
                'nome' => 'Primeiro Molar Superior Esquerdo',
                'quadrante' => 'Q2',
                'arcada' => 'Superior',
                'lado' => 'Esquerdo',
                'ordem' => 6,
                'svg_id' => 'tooth26',
            ],
            [
                'codigo_fdi' => '27',
                'nome' => 'Segundo Molar Superior Esquerdo',
                'quadrante' => 'Q2',
                'arcada' => 'Superior',
                'lado' => 'Esquerdo',
                'ordem' => 7,
                'svg_id' => 'tooth27',
            ],
            [
                'codigo_fdi' => '28',
                'nome' => 'Terceiro Molar Superior Esquerdo',
                'quadrante' => 'Q2',
                'arcada' => 'Superior',
                'lado' => 'Esquerdo',
                'ordem' => 8,
                'svg_id' => 'tooth28',
            ],

            // Quadrante 3 - Inferior Esquerdo
            [
                'codigo_fdi' => '31',
                'nome' => 'Incisivo Central Inferior Esquerdo',
                'quadrante' => 'Q3',
                'arcada' => 'Inferior',
                'lado' => 'Esquerdo',
                'ordem' => 1,
                'svg_id' => 'tooth31',
            ],
            [
                'codigo_fdi' => '32',
                'nome' => 'Incisivo Lateral Inferior Esquerdo',
                'quadrante' => 'Q3',
                'arcada' => 'Inferior',
                'lado' => 'Esquerdo',
                'ordem' => 2,
                'svg_id' => 'tooth32',
            ],
            [
                'codigo_fdi' => '33',
                'nome' => 'Canino Inferior Esquerdo',
                'quadrante' => 'Q3',
                'arcada' => 'Inferior',
                'lado' => 'Esquerdo',
                'ordem' => 3,
                'svg_id' => 'tooth33',
            ],
            [
                'codigo_fdi' => '34',
                'nome' => 'Primeiro Pré-Molar Inferior Esquerdo',
                'quadrante' => 'Q3',
                'arcada' => 'Inferior',
                'lado' => 'Esquerdo',
                'ordem' => 4,
                'svg_id' => 'tooth34',
            ],
            [
                'codigo_fdi' => '35',
                'nome' => 'Segundo Pré-Molar Inferior Esquerdo',
                'quadrante' => 'Q3',
                'arcada' => 'Inferior',
                'lado' => 'Esquerdo',
                'ordem' => 5,
                'svg_id' => 'tooth35',
            ],
            [
                'codigo_fdi' => '36',
                'nome' => 'Primeiro Molar Inferior Esquerdo',
                'quadrante' => 'Q3',
                'arcada' => 'Inferior',
                'lado' => 'Esquerdo',
                'ordem' => 6,
                'svg_id' => 'tooth36',
            ],
            [
                'codigo_fdi' => '37',
                'nome' => 'Segundo Molar Inferior Esquerdo',
                'quadrante' => 'Q3',
                'arcada' => 'Inferior',
                'lado' => 'Esquerdo',
                'ordem' => 7,
                'svg_id' => 'tooth37',
            ],
            [
                'codigo_fdi' => '38',
                'nome' => 'Terceiro Molar Inferior Esquerdo',
                'quadrante' => 'Q3',
                'arcada' => 'Inferior',
                'lado' => 'Esquerdo',
                'ordem' => 8,
                'svg_id' => 'tooth38',
            ],

            // Quadrante 4 - Inferior Direito
            [
                'codigo_fdi' => '41',
                'nome' => 'Incisivo Central Inferior Direito',
                'quadrante' => 'Q4',
                'arcada' => 'Inferior',
                'lado' => 'Direito',
                'ordem' => 1,
                'svg_id' => 'tooth41',
            ],
            [
                'codigo_fdi' => '42',
                'nome' => 'Incisivo Lateral Inferior Direito',
                'quadrante' => 'Q4',
                'arcada' => 'Inferior',
                'lado' => 'Direito',
                'ordem' => 2,
                'svg_id' => 'tooth42',
            ],
            [
                'codigo_fdi' => '43',
                'nome' => 'Canino Inferior Direito',
                'quadrante' => 'Q4',
                'arcada' => 'Inferior',
                'lado' => 'Direito',
                'ordem' => 3,
                'svg_id' => 'tooth43',
            ],
            [
                'codigo_fdi' => '44',
                'nome' => 'Primeiro Pré-Molar Inferior Direito',
                'quadrante' => 'Q4',
                'arcada' => 'Inferior',
                'lado' => 'Direito',
                'ordem' => 4,
                'svg_id' => 'tooth44',
            ],
            [
                'codigo_fdi' => '45',
                'nome' => 'Segundo Pré-Molar Inferior Direito',
                'quadrante' => 'Q4',
                'arcada' => 'Inferior',
                'lado' => 'Direito',
                'ordem' => 5,
                'svg_id' => 'tooth45',
            ],
            [
                'codigo_fdi' => '46',
                'nome' => 'Primeiro Molar Inferior Direito',
                'quadrante' => 'Q4',
                'arcada' => 'Inferior',
                'lado' => 'Direito',
                'ordem' => 6,
                'svg_id' => 'tooth46',
            ],
            [
                'codigo_fdi' => '47',
                'nome' => 'Segundo Molar Inferior Direito',
                'quadrante' => 'Q4',
                'arcada' => 'Inferior',
                'lado' => 'Direito',
                'ordem' => 7,
                'svg_id' => 'tooth47',
            ],
            [
                'codigo_fdi' => '48',
                'nome' => 'Terceiro Molar Inferior Direito',
                'quadrante' => 'Q4',
                'arcada' => 'Inferior',
                'lado' => 'Direito',
                'ordem' => 8,
                'svg_id' => 'tooth48',
            ],

            // Quadrante 5 - Superior Direito (Decíduo)
            [
                'codigo_fdi' => '51',
                'nome' => 'Incisivo Central Superior Direito Decíduo',
                'quadrante' => 'Q5',
                'arcada' => 'Superior',
                'lado' => 'Direito',
                'ordem' => 1,
                'svg_id' => 'tooth51',
            ],
            [
                'codigo_fdi' => '52',
                'nome' => 'Incisivo Lateral Superior Direito Decíduo',
                'quadrante' => 'Q5',
                'arcada' => 'Superior',
                'lado' => 'Direito',
                'ordem' => 2,
                'svg_id' => 'tooth52',
            ],
            [
                'codigo_fdi' => '53',
                'nome' => 'Canino Superior Direito Decíduo',
                'quadrante' => 'Q5',
                'arcada' => 'Superior',
                'lado' => 'Direito',
                'ordem' => 3,
                'svg_id' => 'tooth53',
            ],
            [
                'codigo_fdi' => '54',
                'nome' => 'Primeiro Molar Superior Direito Decíduo',
                'quadrante' => 'Q5',
                'arcada' => 'Superior',
                'lado' => 'Direito',
                'ordem' => 4,
                'svg_id' => 'tooth54',
            ],
            [
                'codigo_fdi' => '55',
                'nome' => 'Segundo Molar Superior Direito Decíduo',
                'quadrante' => 'Q5',
                'arcada' => 'Superior',
                'lado' => 'Direito',
                'ordem' => 5,
                'svg_id' => 'tooth55',
            ],

            // Quadrante 6 - Superior Esquerdo (Decíduo)
            [
                'codigo_fdi' => '61',
                'nome' => 'Incisivo Central Superior Esquerdo Decíduo',
                'quadrante' => 'Q4',
                'arcada' => 'Superior',
                'lado' => 'Esquerdo',
                'ordem' => 1,
                'svg_id' => 'tooth61',
            ],
            [
                'codigo_fdi' => '62',
                'nome' => 'Incisivo Lateral Superior Esquerdo Decíduo',
                'quadrante' => 'Q4',
                'arcada' => 'Superior',
                'lado' => 'Esquerdo',
                'ordem' => 2,
                'svg_id' => 'tooth62',
            ],
            [
                'codigo_fdi' => '63',
                'nome' => 'Canino Superior Esquerdo Decíduo',
                'quadrante' => 'Q4',
                'arcada' => 'Superior',
                'lado' => 'Esquerdo',
                'ordem' => 3,
                'svg_id' => 'tooth63',
            ],
            [
                'codigo_fdi' => '64',
                'nome' => 'Primeiro Molar Superior Esquerdo Decíduo',
                'quadrante' => 'Q4',
                'arcada' => 'Superior',
                'lado' => 'Esquerdo',
                'ordem' => 4,
                'svg_id' => 'tooth64',
            ],
            [
                'codigo_fdi' => '65',
                'nome' => 'Segundo Molar Superior Esquerdo Decíduo',
                'quadrante' => 'Q4',
                'arcada' => 'Superior',
                'lado' => 'Esquerdo',
                'ordem' => 5,
                'svg_id' => 'tooth65',
            ],

            // Quadrante 7 - Inferior Esquerdo (Decíduo)
            [
                'codigo_fdi' => '71',
                'nome' => 'Incisivo Central Inferior Esquerdo Decíduo',
                'quadrante' => 'Q7',
                'arcada' => 'Inferior',
                'lado' => 'Esquerdo',
                'ordem' => 1,
                'svg_id' => 'tooth71',
            ],
            [
                'codigo_fdi' => '72',
                'nome' => 'Incisivo Lateral Inferior Esquerdo Decíduo',
                'quadrante' => 'Q7',
                'arcada' => 'Inferior',
                'lado' => 'Esquerdo',
                'ordem' => 2,
                'svg_id' => 'tooth72',
            ],
            [
                'codigo_fdi' => '73',
                'nome' => 'Canino Inferior Esquerdo Decíduo',
                'quadrante' => 'Q7',
                'arcada' => 'Inferior',
                'lado' => 'Esquerdo',
                'ordem' => 3,
                'svg_id' => 'tooth73',
            ],
            [
                'codigo_fdi' => '74',
                'nome' => 'Primeiro Molar Inferior Esquerdo Decíduo',
                'quadrante' => 'Q7',
                'arcada' => 'Inferior',
                'lado' => 'Esquerdo',
                'ordem' => 4,
                'svg_id' => 'tooth74',
            ],
            [
                'codigo_fdi' => '75',
                'nome' => 'Segundo Molar Inferior Esquerdo Decíduo',
                'quadrante' => 'Q7',
                'arcada' => 'Inferior',
                'lado' => 'Esquerdo',
                'ordem' => 5,
                'svg_id' => 'tooth75',
            ],

            // Quadrante 8 - Inferior Direito (Decíduo)
            [
                'codigo_fdi' => '81',
                'nome' => 'Incisivo Central Inferior Direito Decíduo',
                'quadrante' => 'Q8',
                'arcada' => 'Inferior',
                'lado' => 'Direito',
                'ordem' => 1,
                'svg_id' => 'tooth81',
            ],
            [
                'codigo_fdi' => '82',
                'nome' => 'Incisivo Lateral Inferior Direito Decíduo',
                'quadrante' => 'Q8',
                'arcada' => 'Inferior',
                'lado' => 'Direito',
                'ordem' => 2,
                'svg_id' => 'tooth82',
            ],
            [
                'codigo_fdi' => '83',
                'nome' => 'Canino Inferior Direito Decíduo',
                'quadrante' => 'Q8',
                'arcada' => 'Inferior',
                'lado' => 'Direito',
                'ordem' => 3,
                'svg_id' => 'tooth83',
            ],
            [
                'codigo_fdi' => '84',
                'nome' => 'Primeiro Molar Inferior Direito Decíduo',
                'quadrante' => 'Q8',
                'arcada' => 'Inferior',
                'lado' => 'Direito',
                'ordem' => 4,
                'svg_id' => 'tooth84',
            ],
            [
                'codigo_fdi' => '85',
                'nome' => 'Segundo Molar Inferior Direito Decíduo',
                'quadrante' => 'Q8',
                'arcada' => 'Inferior',
                'lado' => 'Direito',
                'ordem' => 5,
                'svg_id' => 'tooth85',
            ],

        ];

        foreach ($dentes as $dente) {

            $codigo = (int) $dente['codigo_fdi'];
            $dente['tipo_denticao_id'] = $codigo >= 50 ? 1 : 3;
            $dente['sexo'] = 'Ambos';
            $dente['imagem_svg'] = null;
            $dente['ativo'] = true;

            // Corrige o quadrante caso venha como "Q1", "Q2", etc.
            if (is_string($dente['quadrante'])) {
                $dente['quadrante'] = (int) str_replace('Q', '', $dente['quadrante']);
            }

            Dente::updateOrCreate(
                [
                    'codigo_fdi' => $dente['codigo_fdi'],
                    'tipo_denticao_id' => $dente['tipo_denticao_id'],
                ],
                $dente
            );
        }
    }
}
