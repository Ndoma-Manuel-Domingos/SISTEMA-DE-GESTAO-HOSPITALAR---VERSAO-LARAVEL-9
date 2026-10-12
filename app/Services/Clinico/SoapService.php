<?php

namespace App\Services\Clinico;

class SoapService
{
    public function adicionar(string $tipo, string $texto, $consulta)
    {
        switch ($tipo) {
            case 'paciente':
                $consulta->subjetivo = trim(
                    $consulta->subjetivo  . " "  . $texto
                );
                break;

            case 'medico':
                $consulta->objetivo = trim(
                    $consulta->objetivo  . " " . $texto
                );
                break;
        }

        $consulta->save();

        return $consulta;
    }
}
