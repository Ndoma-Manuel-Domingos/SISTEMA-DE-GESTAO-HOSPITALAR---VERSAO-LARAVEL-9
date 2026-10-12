<?php

namespace App\Services\Transcricao;


class TranscricaoService
{

    public function processar(string $texto)
    {
        $texto = trim($texto);
        $texto = $this->corrigirEspacos($texto);
        $texto = $this->formatarFrases($texto);

        return [
            'original' => $texto,
            'processado' => $texto
        ];
    }

    private function corrigirEspacos(string $texto)
    {
        return preg_replace('/\s+/', ' ', $texto);
    }

    private function formatarFrases(string $texto)
    {
        $texto = ucfirst(strtolower($texto));
        return $texto . '.';
    }
}
