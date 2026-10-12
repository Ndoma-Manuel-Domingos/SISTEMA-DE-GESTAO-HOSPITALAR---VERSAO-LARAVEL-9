<?php

namespace App\Services\Clinico;

class MedicalTextProcessor
{

    protected array $dictionary = [
        "dor no peito" => "dor torácica",
        "falta de ar" => "dispneia",
        "canseira" => "fadiga",
        "febre alta" => "hipertermia",
        "dor de barriga" => "dor abdominal",
        "vomito" => "vômitos",
        "tontura" => "tonturas"
    ];

    public function processar(string $texto)
    {
        $texto = mb_strtolower(trim($texto));
        $texto = $this->corrigirTermos($texto);
        $texto = $this->formatarTexto($texto);
        return $texto;
    }

    private function corrigirTermos(string $texto)
    {
        foreach ($this->dictionary as $original => $clinico) {
            $texto = str_replace($original, $clinico, $texto);
        }
        return $texto;
    }

    private function formatarTexto(string $texto)
    {
        $texto = ucfirst($texto);

        if (!str_ends_with($texto, ".")) {
            $texto .= ".";
        }
        return $texto;
    }
}
