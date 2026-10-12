<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SaveTranscricaoRequest;
use App\Models\Consulta;
use App\Models\ConsultaTranscricao;
use App\Models\User;
use App\Services\Clinico\SoapService;
use App\Services\Transcricao\TranscricaoService;
use Illuminate\Support\Facades\Auth;

use App\Services\Clinico\MedicalTextProcessor;
use App\Services\Clinico\SymptomExtractor;
use App\Models\ConsultaSintoma;
use App\Models\ConsultaEntidade;
use App\Services\Clinico\ClinicalEntityExtractor;
use App\Services\Clinico\SummaryService;

class ConsultaTranscricaoController extends Controller
{
    public function salvar(
        SaveTranscricaoRequest $request,
        TranscricaoService $service,
        SoapService $soap,
        MedicalTextProcessor $processor,
        SymptomExtractor $extractor,
        ClinicalEntityExtractor $extractorIntensidade,
        SummaryService $summaryService
    ) {
        $entidade = User::with(['empresa'])->findOrFail(Auth::user()->id);

        $consulta = Consulta::findOrFail($request->consulta_id);

        $textoClinico = $processor->processar($request->texto);
        $sintomas = $extractor->extract($textoClinico);

        foreach ($sintomas as $sintoma) {
            ConsultaSintoma::firstOrCreate([
                'consulta_id' => $consulta->id,
                'sintoma' => $sintoma,
                'user_id' => auth()->id(),
                'entidade_id' => $entidade->empresa->id,
            ]);
        }

        $dados = $extractorIntensidade->extract($request->texto);
        foreach ($dados as $tipo => $lista) {
            if (!is_array($lista)) {
                continue;
            }
            foreach ($lista as $valor) {
                ConsultaEntidade::firstOrCreate([
                    'consulta_id' => $request->consulta_id,
                    'tipo' => $tipo,
                    'valor' => $valor,
                    'user_id' => auth()->id(),
                    'entidade_id' => $entidade->empresa->id,
                ]);
            }
        }

        $resultado =  $service->processar($request->texto);

        $tipo = $request->tipo ?? 'paciente';

        $soap->adicionar(
            $tipo,
            $resultado['processado'],
            $consulta
        );

        $resumo = $summaryService->generate($consulta);

        $consulta->update([
            'resumo_clinico' => $resumo
        ]);

        $consulta->update([
            'queixa_principal' => $resultado['processado']
        ]);

        $transcricao = ConsultaTranscricao::create([
            'consulta_id' => $consulta->id,
            'texto' => $resultado['processado'],
            'texto_original' => $resultado['original'],
            'texto_processado' => $resultado['processado'],
            'tipo' => $tipo,
            'momento' => now(),
            'user_id' => auth()->id(),
            'entidade_id' => $entidade->empresa->id,
        ]);

        return response()->json([
            'success' => true,
            'texto' => $resultado['processado'],
            'resumo_clinico' => $resumo,
            'id' => $transcricao->id
        ]);
    }
}
