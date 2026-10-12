<?php

namespace App\Services\Clinico;

use App\Models\ConsultaEntidade;

class SummaryService
{

    public function generate($consulta): string
    {
        $entidades = ConsultaEntidade::where('consulta_id', $consulta->id)->get();

        $texto = [];

        $texto[] = "RESUMO DO RELATO";
        $texto[] = "";

        $this->section($texto, "Queixa principal", [$consulta->queixa]);

        $this->section($texto, "Sintomas referidos", $entidades->where('tipo', 'sintoma')->pluck('valor')->unique()->values()->toArray());

        $this->section($texto, "Tempo de evolução", $entidades->where('tipo', 'duracao')->pluck('valor')->unique()->values()->toArray());

        $this->section($texto, "Medicação referida", $entidades->where('tipo', 'medicamentos')->pluck('valor')->unique()->values()->toArray());

        $this->section($texto, "Alergias referidas", $entidades->where('tipo', 'alergias')->pluck('valor')->unique()->values()->toArray());

        $texto[] = "";
        $texto[] = "As informações acima resultam do relato do paciente e devem ser confirmadas pelo profissional de saúde.";

        return implode(PHP_EOL, $texto);
    }

    private function section(array &$texto, string $titulo, array $itens): void
    {
        if (empty($itens)) {
            return;
        }

        $texto[] = $titulo;
        foreach ($itens as $item) {
            $texto[] = "• " . $item;
        }
        $texto[] = "";
    }
}
