<?php

namespace App\Services\Clinico;

class SymptomExtractor
{
    protected array $symptoms = [
        "dor torácica",
        "dispneia",
        "febre",
        "tosse",
        "náusea",
        "vômitos",
        "tonturas",
        "cefaleia"
    ];

    public function extract(string $texto)
    {
        $found = [];

        foreach ($this->symptoms as $symptom) {
            if (str_contains(mb_strtolower($texto), $symptom)) {
                $found[] = $symptom;
            }
        }

        return $found;
    }
}
