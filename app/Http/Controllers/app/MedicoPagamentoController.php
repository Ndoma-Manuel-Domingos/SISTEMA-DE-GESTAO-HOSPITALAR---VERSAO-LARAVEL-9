<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TraitHelpers;
use App\Models\AgenteComissao;
use App\Models\AgentePagamento;
use App\Models\AgentePagamentoItem;
use App\Models\Caixa;
use App\Models\ContaBancaria;
use App\Models\Dispesa;
use App\Models\Entidade;
use App\Models\Fornecedore;
use App\Models\Imposto;
use App\Models\Medico;
use App\Models\MedicoComissao;
use App\Models\MedicoPagamento;
use App\Models\MedicoPagamentoItem;
use App\Models\Motivo;
use App\Models\OperacaoFinanceiro;
use App\Models\Produto;
use App\Models\TipoPagamento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

use PDF;

class MedicoPagamentoController extends Controller
{
    use TraitHelpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $entidade = User::with(['empresa'])->findOrFail(Auth::user()->id);
        $medicos = Medico::with(['my_user'])->where("entidade_id", $entidade->empresa->id)->get();

        $empresa = Entidade::with(['variacoes', 'clientes', 'marcas', 'categorias'])->findOrFail($entidade->empresa->id);

        $saida = OperacaoFinanceiro::where('entidade_id', $entidade->empresa->id)->where('type', 'D')->count() + 1;

        $tipos = Dispesa::where('type', 'D')->where('entidade_id', $entidade->empresa->id)->get();
        $observacao = "NOTA DE SAÍDA Nº " . $saida;

        $caixas = Caixa::where('entidade_id', '=', $entidade->empresa->id)->where('status_admin', 'liberado')->get();
        $bancos = ContaBancaria::where('entidade_id', '=', $entidade->empresa->id)->get();
        $formas_pagamentos = TipoPagamento::get();

        $head = [
            "titulo" => "Pagamento de médicos",
            "descricao" => env('APP_NAME'),
            "medicos" => $medicos,
            "empresa" => $empresa,

            "formas_pagamentos" => $formas_pagamentos,
            "tipos" => $tipos,
            "caixas" => $caixas,
            "bancos" => $bancos,
            "observacao" => $observacao,

            "empresa_logada" => User::with(['empresa.empresa_modulos', 'empresa.tipo_entidade'])->findOrFail(Auth::user()->id),
        ];

        return view('dashboard.medicos.pagamento', $head);
    }

    public function comissoes(Medico $medico)
    {
        $comissoes = $medico->comissoes()
            ->with(['cliente', 'servico'])
            ->where('status', false)
            ->get();

        if ($comissoes->isEmpty()) {
            return response()->json([
                'status' => false,
                'medico' => $medico,
                'summary' => [
                    'clients' => 0,
                    'total' => 0
                ],
                'comissoes' => 0,
                'message' => 'Este medico não possui comissões pendentes.'
            ]);
        }

        return response()->json([
            'status' => true,
            'medico' => $medico,
            'summary' => [
                'clients' => $comissoes->count(),
                'total' => $comissoes->sum('valor')
            ],
            'comissoes' => $comissoes
        ]);
    }

    private function generateNumber()
    {
        $last = MedicoPagamento::latest()->first();
        if (!$last) {
            return 'PAG000001';
        }
        $number = intval(substr($last->numero, 3));
        $number++;
        return 'PAG' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }

    public function store(Request $request)
    {

        $request->validate([
            'forma_pagamento_id' => 'required|string',
            'medico_selecionado_id' => 'required|exists:medicos,id',
        ]);

        $formaPagamento = TipoPagamento::findOrFail($request->forma_pagamento_id);

        $motante1 = 0;
        $motante2 = 0;
        $motante_final = 0;

        if ($formaPagamento->tipo === "NU") {
            $request->validate([
                'caixa_id' => 'required|string',
                'motante' => 'required|string',
            ]);

            $motante1 = $request->motante ?? 0;
        }

        if ($formaPagamento->tipo === "MB" || $formaPagamento->tipo === "DE" || $formaPagamento->tipo === "TE") {
            $request->validate([
                'banco_id' => 'required|string',
                'motante_banco' => 'required|string',
            ]);

            $motante2 = $request->motante_banco ?? 0;
        }

        if ($formaPagamento->tipo === "OU") {
            $request->validate([
                'caixa_id' => 'required|string',
                'banco_id' => 'required|string',
                'motante' => 'required|string',
                'motante_banco' => 'required|string',
            ]);

            $motante1 = $request->motante ?? 0;
            $motante2 = $request->motante_banco ?? 0;
        }

        $motante_final =  $motante1 + $motante2;

        $comissoes = MedicoComissao::where('medico_id', $request->medico_selecionado_id)->where('status', false)->get();

        if ($comissoes->isEmpty()) {
            return response()->json([
                'message' => 'Não existem comissões pendentes.'
            ], 404);
        }

        $total = $comissoes->sum('valor');

        if ($motante_final !== $total) {
            return response()->json([
                'message' => 'Não foi possível processar a operação. Verifique o valor informado e tente novamente.!'
            ], 404);
        }

        $data_at = date("Y-m-d");

        $entidade = User::with(["empresa"])->findOrFail(Auth::user()->id);

        DB::beginTransaction();

        try {

            $code = uniqid(time());

            $medico = Medico::findOrFail($request->medico_selecionado_id);

            $tipo = Dispesa::findOrFail($request->tipo_id);

            if ($formaPagamento->tipo == "NU") {
                $caixa = Caixa::find($request->caixa_id);
                $verificar_saldo = $this->saldo_conta($caixa->subconta_id);
                if ($motante_final > $verificar_saldo) {
                    return response()->json(['message' => "Pretende realizar o pagamento utilizando os fundos do caixa: {$caixa->conta} - {$caixa->nome}. No entanto, o saldo atual não é suficiente para cobrir essa despesa. Sugerimos adicionar fundos a este caixa para prosseguir com a transação."], 404);
                }
                // finanças
                OperacaoFinanceiro::create([
                    'nome' => $tipo->nome,
                    'status' => 'pago',
                    'motante' => (float) $motante_final,
                    'formas' => 'C',
                    'parcelado' => NULL,
                    'parcelas' => NULL,
                    'cliente_id' => NULL,
                    'fornecedor_id' => $request->medico_selecionado_id,
                    'code_caixa' => $caixa ? $caixa->code_caixa : NULL,
                    'status_caixa' => $caixa ? 'pendente' : 'concluido',
                    'subconta_id' => $caixa->subconta_id,
                    'model_id' => $tipo->id,
                    'loja_id' => $this->LOJA_ACTIVA_USER() ? $this->LOJA_ACTIVA_USER()->id  : NULL,
                    'type' => "D",
                    'status_pagamento' => 'pago',
                    'centro_custo_id' => NULL,
                    'code' => $code,
                    'descricao' => "Pagamento de comissão ao Médico: { $medico->nome ?? '' }",
                    'movimento' => "S",
                    'date_at' => $data_at,
                    'user_id' => Auth::user()->id,
                    'user_open_id' => Auth::user()->id,
                    'comprovativo' => NULL,
                    'entidade_id' => $entidade->empresa->id,
                    'exercicio_id' => $this->exercicio(),
                    'periodo_id' => $this->periodo(),
                ]);
            }

            if ($formaPagamento->tipo == "MB" || $formaPagamento->tipo == "DE" || $formaPagamento->tipo == "TE") {
                $banco = ContaBancaria::find($request->banco_id);

                $verificar_saldo = $this->saldo_conta($banco->subconta_id);

                if ($motante_final > $verificar_saldo) {
                    return response()->json(['message' => "Pretende realizar o pagamento utilizando os fundos da conta bancária: {$banco->conta} - {$banco->nome}. No entanto, o saldo atual não é suficiente para cobrir essa despesa. Sugerimos adicionar fundos a esta conta bancária para prosseguir com a transação."], 404);
                }

                OperacaoFinanceiro::create([
                    'nome' => $tipo->nome,
                    'status' => 'pago',
                    'motante' => (float) $motante_final,
                    'formas' => 'B',
                    'parcelado' => NULL,
                    'parcelas' => NULL,
                    'cliente_id' => NULL,
                    'fornecedor_id' => $request->medico_selecionado_id,
                    'code_caixa' => $banco ? $banco->code_caixa : NULL,
                    'status_caixa' => $banco ? 'pendente' : 'concluido',
                    'subconta_id' => $banco->subconta_id,
                    'model_id' => $request->tipo_id,
                    'type' =>  "D",
                    'status_pagamento' => 'pago',
                    'centro_custo_id' => NULL,
                    'code' => $code,
                    'loja_id' => $this->LOJA_ACTIVA_USER() ? $this->LOJA_ACTIVA_USER()->id  : NULL,
                    'descricao' => "Pagamento de comissão ao Médico: { $medico->nome ?? '' }",
                    'movimento' => "S",
                    'date_at' => $data_at,
                    'user_id' => Auth::user()->id,
                    'user_open_id' => Auth::user()->id,
                    'entidade_id' => $entidade->empresa->id,
                    'exercicio_id' => $this->exercicio(),
                    'periodo_id' => $this->periodo(),
                ]);
            }

            if ($formaPagamento->tipo == "OU") {

                $caixa = Caixa::find($request->caixa_id);
                $banco = ContaBancaria::find($request->banco_id);

                $verificar_saldo1 = $this->saldo_conta($caixa->subconta_id);

                if ($request->motante > $verificar_saldo1) {
                    return response()->json(['message' => "Pretende realizar o pagamento utilizando os fundos do caixa: {$caixa->conta} - {$caixa->nome}. No entanto, o saldo atual não é suficiente para cobrir essa despesa. Sugerimos adicionar fundos a este caixa para prosseguir com a transação."], 404);
                }

                $verificar_saldo = $this->saldo_conta($banco->subconta_id);

                if ($request->motante_banco > $verificar_saldo) {
                    return response()->json(['message' => "Pretende realizar o pagamento utilizando os fundos da conta bancária: {$banco->conta} - {$banco->nome}. No entanto, o saldo atual não é suficiente para cobrir essa despesa. Sugerimos adicionar fundos a esta conta bancária para prosseguir com a transação."], 404);
                }

                OperacaoFinanceiro::create([
                    'nome' => $tipo->nome,
                    'status' => 'pago',
                    'motante' => (float) $request->motante,
                    'formas' => 'C',
                    'parcelado' => NULL,
                    'parcelas' => NULL,
                    'cliente_id' => NULL,
                    'fornecedor_id' => $request->medico_selecionado_id,
                    'code_caixa' => $caixa ? $caixa->code_caixa : NULL,
                    'status_caixa' => $caixa ? 'pendente' : 'concluido',
                    'subconta_id' => $caixa->subconta_id,
                    'model_id' => $request->tipo_id,
                    'type' => "D",
                    'status_pagamento' => 'pago',
                    'centro_custo_id' => NULL,
                    'loja_id' => $this->LOJA_ACTIVA_USER() ? $this->LOJA_ACTIVA_USER()->id  : NULL,
                    'code' => $code,
                    'descricao' => "Pagamento de comissão ao Médico: { $medico->nome ?? '' }",
                    'movimento' => "S",
                    'date_at' => $data_at,
                    'user_id' => Auth::user()->id,
                    'user_open_id' => Auth::user()->id,
                    'entidade_id' => $entidade->empresa->id,
                    'exercicio_id' => $this->exercicio(),
                    'periodo_id' => $this->periodo(),
                ]);

                OperacaoFinanceiro::create([
                    'nome' => $tipo->nome,
                    'status' => 'pago',
                    'motante' => (float) $request->motante_banco,
                    'formas' => 'B',
                    'parcelado' => NULL,
                    'parcelas' => NULL,
                    'cliente_id' => NULL,
                    'fornecedor_id' => $request->medico_selecionado_id,
                    'code_caixa' => $banco ? $banco->code_caixa : NULL,
                    'status_caixa' => $banco ? 'pendente' : 'concluido',
                    'subconta_id' => $banco->subconta_id,
                    'model_id' => $request->tipo_id,
                    'type' => "D",
                    'status_pagamento' => 'pago',
                    'loja_id' => $this->LOJA_ACTIVA_USER() ? $this->LOJA_ACTIVA_USER()->id  : NULL,
                    'centro_custo_id' => NULL,
                    'code' => $code,
                    'descricao' => "Pagamento de comissão ao Médico: { $medico->nome ?? '' }",
                    'movimento' => "S",
                    'date_at' => $data_at,
                    'user_id' => Auth::user()->id,
                    'user_open_id' => Auth::user()->id,
                    'entidade_id' => $entidade->empresa->id,
                    'exercicio_id' => $this->exercicio(),
                    'periodo_id' => $this->periodo(),
                ]);
            }

            $medico->saldo -= $total;
            $medico->save();

            $pagamento = MedicoPagamento::create([
                'medico_id' => $request->medico_selecionado_id,
                'numero' => $this->generateNumber(),
                'data_at' => now(),
                'total' => $total,
                'forma_pagamento_id' => $formaPagamento->id ?? NULL,
                'referencia' => $request->referencia,
                'observacao' => $request->observacao,
                'user_id' => Auth::user()->id,
                'entidade_id' => $entidade->empresa->id,
            ]);

            foreach ($comissoes as $comissao) {
                MedicoPagamentoItem::create([
                    'medico_pagamento_id' => $pagamento->id,
                    'comissao_id' => $comissao->id,
                    'valor' => $comissao->valor,
                    'user_id' => Auth::user()->id,
                    'entidade_id' => $entidade->empresa->id,
                ]);

                $comissao->update([
                    'status' => true,
                    'pago_em' => now(),
                    'medico_pagamento_id' => $pagamento->id
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Pagamento realizado com sucesso.',
                'pagamento' => $pagamento
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function configurarComissoesStore(Request $request)
    {
        $dados = $request->validate([
            'percentagem' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        try {

            DB::transaction(function () use ($dados) {
                $user = Auth::user()->load('empresa');
                if (!$user->empresa) {
                    throw new \Exception('Empresa não encontrada.');
                }

                $empresa = $user->empresa;
                // Busca apenas uma vez
                $imposto = Imposto::findOrFail($produtp->imposto_id ?? $empresa->imposto_id);
                $motivo = Motivo::findOrFail($produtp->motivo_id ?? $empresa->motivo_id);

                Produto::where('entidade_id', $empresa->id)->chunkById(300, function ($produtos) use ($dados, $motivo, $imposto, $empresa) {
                    foreach ($produtos as $produto) {
                        $percentagem = $dados['percentagem'];
                        $precoBase = $produto->preco_venda;

                        if ($empresa->forma_comissao_agente === "P") {
                            $valorComissao = round($precoBase * ($percentagem / 100), 2);
                            $novoPreco = round($precoBase + $valorComissao, 2);
                            $precoComIVA = round($novoPreco + ($novoPreco * ($imposto->valor / 100)), 2);
                        } else {
                            $valorComissao = $percentagem;
                            $novoPreco = round($precoBase + $valorComissao, 2);
                            $precoComIVA = round($novoPreco + ($novoPreco * ($imposto->valor / 100)), 2);
                        }

                        $produto->update([
                            'comissao_percentagem' => $percentagem,
                            'comissao_valor' => $valorComissao,
                            'preco_venda' => $novoPreco,
                            'preco_venda_com_iva' => $precoComIVA,
                            'imposto_id' => $imposto->id,
                            'imposto' => $imposto->codigo,
                            'taxa' => $imposto->valor,
                            'motivo_id' => $motivo->id,
                            'motivo_isencao' => $motivo->codigo,
                        ]);
                    }
                });
            });

            return response()->json([
                'success' => true,
                'message' => 'Comissão aplicada com sucesso.'
            ]);
        } catch (\Throwable $e) {
            Log::error('Erro ao configurar comissão.', [
                'erro' => $e->getMessage(),
                'linha' => $e->getLine(),
                'arquivo' => $e->getFile(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Não foi possível aplicar a comissão.'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function imprimir(string $id)
    {
        $pagamento = MedicoPagamento::with([
            "items.comissao.servico.categoria",
            "items.comissao.cliente",
            "forma_pagamento",
            'medico.my_user'
        ])->findOrFail($id);

        // dd($pagamento);

        // Caminho da imagem
        $logotipoPath = public_path("images/empresa/{$this->LOJA_ACTIVA_USER()->logotipo}");
        $temLogotipo = File::exists($logotipoPath);

        $head = [
            "titulo" => "COMPROVATIVO DE PAGAMENTO DE COMISSÃO",
            "descricao" => env('APP_NAME'),
            "pagamento" => $pagamento,
            "logotipo" => $temLogotipo ? $logotipoPath : public_path('/images/empresa/logo-default.png'),
            "empresa_logada" => User::with(['empresa.empresa_modulos', 'empresa.tipo_entidade'])->findOrFail(Auth::user()->id),
        ];

        $pdf = PDF::loadView('dashboard.medicos.imprimir', $head);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream();
    }
}
