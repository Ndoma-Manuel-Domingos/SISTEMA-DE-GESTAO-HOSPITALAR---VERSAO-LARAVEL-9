<?php

namespace App\Services\Clinico;

class ClinicalEntityExtractor
{

    protected array $medicamentos = [
        "paracetamol",
        "ibuprofeno",
        "losartana",
        "metformina",
        "amoxicilina",
        "insulina"
    ];

    protected array $alergias = [
        "penicilina",
        "dipirona",
        "amoxicilina",
        "marisco",
        "amendoim"
    ];

    protected array $localizacoes = [
        "peito",
        "cabeça",
        "abdómen",
        "estômago",
        "costas",
        "perna",
        "braço"
    ];

    protected array $intensidades = [
        "leve",
        "moderada",
        "forte",
        "muito forte",
        "intensa"
    ];

    public function extract(string $texto): array
    {
        $texto = mb_strtolower($texto);

        return [
            'medicamentos' => $this->findTerms($texto, $this->medicamentos),
            'alergias' => $this->findTerms($texto, $this->alergias),
            'localizacao' => $this->findTerms($texto, $this->localizacoes),
            'intensidade' => $this->findTerms($texto, $this->intensidades),
            'duracao' => $this->extractDuration($texto)
        ];
    }

    private function findTerms(string $texto, array $lista): array
    {
        $resultado = [];
        foreach ($lista as $item) {
            if (str_contains($texto, $item)) {
                $resultado[] = $item;
            }
        }

        return $resultado;
    }

    private function extractDuration(string $texto): array
    {
        preg_match_all(
            '/(\d+)\s*(dia|dias|semana|semanas|mês|meses|ano|anos)/iu',
            $texto,
            $matches
        );
        return $matches[0];
    }
}
