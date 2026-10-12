<?php

namespace App\Http\Controllers\Odontologia;


use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Dente;
use App\Models\EstadoDente;
use App\Models\ProcedimentoOdontologico;
use App\Models\Odontograma;
use App\Models\TipoDenticao;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OdontogramaController extends Controller
{
    public function index($paciente_id)
    {

        /*
        Buscar paciente
        */

        $paciente = Cliente::findOrFail($paciente_id);

        /*
        Calcular idade
        */

        $idade = Carbon::parse($paciente->data_nascimento)->age;

        /*
        Escolher tipo de dentição
        */

        if ($idade <= 6) {
            $tipoDenticao = TipoDenticao::where(
                'nome',
                'Dentição Decídua'
            )->first();
        } elseif ($idade <= 12) {

            $tipoDenticao = TipoDenticao::where(
                'nome',
                'Dentição Mista'
            )->first();
        } else {

            $tipoDenticao = TipoDenticao::where(
                'nome',
                'Dentição Permanente'
            )->first();
        }





        /*
        Carregar SVG principal

        Futuramente virá da tabela
        dentes_svg

        Aqui deixamos preparado
        */

        $svgOdontograma = $this->carregarSvg($tipoDenticao);

        /*
        Estados para legenda
        */

        $estados = EstadoDente::where('ativo', true)
            ->orderBy('nome')
            ->get();

        return view('odontologia.odontograma.index', [
            'paciente' => $paciente,
            'idade' => $idade,
            'tipoDenticao' => $tipoDenticao,
            'svgOdontograma' => $svgOdontograma,
            'estados' => $estados
        ]);
    }

    /**
     * Abrir dados do dente via AJAX
     */
    public function buscarDente($codigo)
    {
        /*
        Busca pelo código FDI

        Ex:
        11
        */

        $dente = Dente::where('codigo_fdi',  $codigo)->firstOrFail();
        /*
        Busca estados cadastrados
        */
        $estados = EstadoDente::where('ativo',  true)->orderBy('nome')->get();
        /*
        Busca procedimentos
        */
        $procedimentos = ProcedimentoOdontologico::where('ativo', true)->orderBy('nome')->get();

        return response()->json([
            'success' => true,
            'dente' => [
                'id' => $dente->id,
                'codigo' => $dente->codigo_fdi,
                'nome' => $dente->nome
            ],
            'estados' => $estados,
            'procedimentos' => $procedimentos
        ]);
    }

    /**
     * Buscar estado atual do paciente
     */
    public function estadoAtual(Request $request)
    {
        $registro = Odontograma::where('paciente_id',  $request->paciente_id)
            ->where('dente_id', $request->dente_id)
            ->latest()
            ->first();

        return response()->json([
            'dados' => $registro
        ]);
    }
}
