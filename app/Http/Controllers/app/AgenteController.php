<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TraitHelpers;
use App\Models\AgenteComissao;
use App\Models\AgentePagamento;
use App\Models\Entidade;
use App\Models\EstadoCivil;
use App\Models\Fornecedore;
use App\Models\Seguradora;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class AgenteController extends Controller
{
    use TraitHelpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Request $request)
    {
        //
        $user = auth()->user();

        if (!$user->can('agente supervisor') && !$user->can('controle de agentes') && !$user->can('agente operador')) {
            return redirect()->back()->with('error-permissao', "Você não possui permissão para esta operação, por favor, contacte o administrador!");
        }

        $entidade = User::with(['empresa'])->findOrFail(Auth::user()->id);
        $empresa = Entidade::with(['variacoes', 'clientes', 'marcas', 'categorias'])->findOrFail($entidade->empresa->id);

        $inicio = $request->inicio ? Carbon::parse($request->inicio) : now()->subDays(30);
        $fim = $request->fim ? Carbon::parse($request->fim) : now();

        $agenteId = "";

        if ($user->can('agente supervisor') || $user->can('agente operador')) {
            $agente = Fornecedore::where('conta_id', $user->id)->where('entidade_id', $entidade->empresa->id)->first();
            if ($agente) {
                $agenteId = $agente->id;
            } else {
                $agenteId = "";
            }
        }

        $totalAgentes = Fornecedore::when($agenteId, function ($query, $value) {
            $query->where('pertence_id', $value);
        })->where('entidade_id', $entidade->empresa->id)->count();

        $agentesAtivos = Fornecedore::when($agenteId, function ($query, $value) {
            $query->where('conta_id', $value);
        })->whereHas('comissoes', function ($q) use ($inicio, $fim) {
            $q->whereBetween('created_at', [$inicio, $fim]);
        })->where('entidade_id', $entidade->empresa->id)->count();

        $pacientes = AgenteComissao::when($agenteId, function ($query, $value) {
            $query->where('agente_id', $value);
        })->whereBetween('created_at', [$inicio, $fim])->where('entidade_id', $entidade->empresa->id)->count();

        $receita = AgenteComissao::when($agenteId, function ($query, $value) {
            $query->where('agente_id', $value);
        })->whereBetween('created_at', [$inicio, $fim])->where('entidade_id', $entidade->empresa->id)->sum('valor');

        $comissaoPendente = AgenteComissao::when($agenteId, function ($query, $value) {
            $query->where('agente_id', $value);
        })->where('status', false)
            ->whereBetween('created_at', [$inicio, $fim])
            ->where('entidade_id', $entidade->empresa->id)
            ->sum('valor');

        $comissaoPaga = AgentePagamento::when($agenteId, function ($query, $value) {
            $query->where('agente_id', $value);
        })->whereBetween('created_at', [$inicio, $fim])->where('entidade_id', $entidade->empresa->id)->sum('total');


        $topAgentesPacientes = AgenteComissao::selectRaw('
            agente_id,
            COUNT(*) as total
        ')
            ->whereBetween('created_at', [
                $inicio,
                $fim
            ])
            ->where('entidade_id', $entidade->empresa->id)
            ->when($agenteId, function ($query, $value) {
                $query->where('agente_id', $value);
            })
            ->groupBy('agente_id')
            ->orderByDesc('total')
            ->limit(10)
            ->with('agente')
            ->get();

        $topAgentesComissao = AgenteComissao::selectRaw('
            agente_id,
            SUM(valor) as total
        ')
            ->where('entidade_id', $entidade->empresa->id)->whereBetween('created_at', [
                $inicio,
                $fim
            ])
            ->when($agenteId, function ($query, $value) {
                $query->where('agente_id', $value);
            })
            ->groupBy('agente_id')
            ->orderByDesc('total')
            ->limit(10)
            ->with('agente')
            ->get();


        $agentesSemMovimento = Fornecedore::whereDoesntHave('comissoes', function ($q) use ($inicio, $fim) {
            $q->whereBetween('created_at', [$inicio, $fim]);
        })
            ->where('entidade_id', $entidade->empresa->id)
            ->when($agenteId, function ($query, $value) {
                $query->where('agente_id', $value);
            })
            ->orderBy('nome')
            ->get();

        $evolucaoComissao = AgenteComissao::selectRaw('
            MONTH(created_at) as mes,
            SUM(valor) as total
        ')
            ->whereYear('created_at', now()->year)
            ->when($agenteId, function ($query, $value) {
                $query->where('agente_id', $value);
            })
            ->where('entidade_id', $entidade->empresa->id)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $head = [
            "titulo" => "Dashboard Agentes",
            "descricao" => env('APP_NAME'),
            "empresa" => $empresa,

            'inicio' => $inicio,
            'fim' => $fim,

            'totalAgentes' => $totalAgentes,
            'agentesAtivos' => $agentesAtivos,
            'pacientes' => $pacientes,
            'receita' => $receita,
            'comissaoPendente' => $comissaoPendente,
            'comissaoPaga' => $comissaoPaga,
            'agentesSemMovimento' => $agentesSemMovimento,

            'topAgentesPacientes' => $topAgentesPacientes,
            'topAgentesComissao' => $topAgentesComissao,
            'evolucaoComissao' => $evolucaoComissao,

            "empresa_logada" => User::with(['empresa.empresa_modulos', 'empresa.tipo_entidade'])->findOrFail(Auth::user()->id),
        ];

        return view('dashboard.agentes.dashboard', $head);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pagamentos()
    {
        $user = auth()->user();

        if (!$user->can('agente supervisor') && !$user->can('controle de agentes') && !$user->can('agente operador')) {
            return redirect()->back()->with('error-permissao', "Você não possui permissão para esta operação, por favor, contacte o administrador!");
        }

        $entidade = User::with(['empresa'])->findOrFail(Auth::user()->id);
        $empresa = Entidade::with(['variacoes', 'clientes', 'marcas', 'categorias'])->findOrFail($entidade->empresa->id);

        $agenteId = "";

        if ($user->can('agente supervisor') || $user->can('agente operador')) {
            $agente = Fornecedore::where('conta_id', $user->id)->where('entidade_id', $entidade->empresa->id)->first();

            if ($agente) {
                $agenteId = $agente->id;
            } else {
                $agenteId = "";
            }
        }

        $entidade = User::with(['empresa'])->findOrFail(Auth::user()->id);

        $pagamentos = AgentePagamento::when($agenteId, function ($query, $value) {
            $query->where('agente_id', $value);
        })->with(['agente', 'forma_pagamento', 'items', 'user'])->where("entidade_id", $entidade->empresa->id)->get();

        $empresa = Entidade::with(['variacoes', 'clientes', 'marcas', 'categorias'])->findOrFail($entidade->empresa->id);

        $head = [
            "titulo" => "Agentes Pagamentos",
            "descricao" => env('APP_NAME'),
            "pagamentos" => $pagamentos,
            "empresa" => $empresa,
            "empresa_logada" => User::with(['empresa.empresa_modulos', 'empresa.tipo_entidade'])->findOrFail(Auth::user()->id),
        ];

        return view('dashboard.agentes.pagamentos', $head);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function comissoes()
    {
        $user = auth()->user();

        if (!$user->can('agente supervisor') && !$user->can('controle de agentes') && !$user->can('agente operador')) {
            return redirect()->back()->with('error-permissao', "Você não possui permissão para esta operação, por favor, contacte o administrador!");
        }

        $entidade = User::with(['empresa'])->findOrFail(Auth::user()->id);

        $agenteId = "";

        if ($user->can('agente supervisor') || $user->can('agente operador')) {
            $agente = Fornecedore::where('conta_id', $user->id)->where('entidade_id', $entidade->empresa->id)->first();

            if ($agente) {
                $agenteId = $agente->id;
            } else {
                $agenteId = "";
            }
        }

        $comissoes = AgenteComissao::when($agenteId, function ($query, $value) {
            $query->where('agente_id', $value);
        })->with(['agente', 'cliente', 'servico.categoria', 'user'])->where("entidade_id", $entidade->empresa->id)->get();

        $empresa = Entidade::with(['variacoes', 'clientes', 'marcas', 'categorias'])->findOrFail($entidade->empresa->id);

        $head = [
            "titulo" => "Comissões de Agentes",
            "descricao" => env('APP_NAME'),
            "comissoes" => $comissoes,
            "empresa" => $empresa,
            "empresa_logada" => User::with(['empresa.empresa_modulos', 'empresa.tipo_entidade'])->findOrFail(Auth::user()->id),
        ];

        return view('dashboard.agentes.comissoes', $head);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $entidade = User::with(['empresa'])->findOrFail(Auth::user()->id);

        $agentes = Fornecedore::with(['conta', 'pertence'])->where("entidade_id", $entidade->empresa->id)->get();

        $empresa = Entidade::with(['variacoes', 'clientes', 'marcas', 'categorias'])->findOrFail($entidade->empresa->id);

        $head = [
            "titulo" => "Agentes",
            "descricao" => env('APP_NAME'),
            "agentes" => $agentes,
            "empresa" => $empresa,
            "empresa_logada" => User::with(['empresa.empresa_modulos', 'empresa.tipo_entidade'])->findOrFail(Auth::user()->id),
        ];

        return view('dashboard.agentes.index', $head);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $entidade = User::with(['empresa'])->findOrFail(Auth::user()->id);
        $empresa = Entidade::with(['variacoes', 'clientes', 'marcas', 'categorias'])->findOrFail($entidade->empresa->id);
        $agentes = Fornecedore::where('entidade_id', $entidade->empresa->id)->get();

        $head = [
            "titulo" => __('messages.novo'),
            "descricao" => env('APP_NAME'),
            "empresa" => $empresa,
            "estados_civils" => EstadoCivil::get(),
            "agentes" => $agentes,
            "seguradores" => Seguradora::where('entidade_id', $entidade->empresa->id)->get(),
            "empresa_logada" => User::with(['empresa.empresa_modulos', 'empresa.tipo_entidade'])->findOrFail(Auth::user()->id),
        ];

        return view('dashboard.fornecedores.create', $head);
    }

    public function status(Request $request, Fornecedore $agente)
    {
        $request->validate([
            'status' => 'required|in:activo,desactivo,suspenso'
        ]);

        $agente->estado = $request->status;
        $agente->save();

        return response()->json([
            'success' => true,
            'message' => 'Estado alterado com sucesso.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $agente = Fornecedore::with(['atendimentos.paciente', 'atendimentos.contaHospitalar.itens.servico', 'pagamentos.items.comissao.servico', 'pagamentos.forma_pagamento'])->findOrFail($id);

        $entidade = User::with(['empresa'])->findOrFail(Auth::user()->id);
        $empresa = Entidade::with(['variacoes', 'clientes', 'marcas', 'categorias'])->findOrFail($entidade->empresa->id);

        $head = [
            "titulo" => "Detalhes do Agente",
            "descricao" => env('APP_NAME'),
            "empresa" => $empresa,
            "agente" => $agente,
            "loja" => User::with(['empresa'])->findOrFail(Auth::user()->id),
            "empresa_logada" => User::with(['empresa.empresa_modulos', 'empresa.tipo_entidade'])->findOrFail(Auth::user()->id),
        ];

        return view('dashboard.agentes.show', $head);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $agente = Fornecedore::findOrFail($id);

        $entidade = User::with(['empresa'])->findOrFail(Auth::user()->id);
        $empresa = Entidade::with(['variacoes', 'clientes', 'marcas', 'categorias'])->findOrFail($entidade->empresa->id);
        $agentes = Fornecedore::where('entidade_id', $entidade->empresa->id)->get();

        $head = [
            "titulo" => "Editar Dados do Agente",
            "descricao" => env('APP_NAME'),
            "empresa" => $empresa,
            "fornecedor" => $agente,
            "estados_civils" => EstadoCivil::get(),
            "agentes" => $agentes,
            "empresa_logada" => User::with(['empresa.empresa_modulos', 'empresa.tipo_entidade'])->findOrFail(Auth::user()->id),
        ];

        return view('dashboard.fornecedores.edit', $head);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            // Realizar operações de banco de dados aqui

            $agente = Fornecedore::findOrFail($id);
            $agente->delete();

            DB::commit();
        } catch (\Exception $e) {
            // Caso ocorra algum erro, você pode fazer rollback para desfazer as operações
            DB::rollback();

            Alert::warning('Informação', $e->getMessage());
            return redirect()->back();
            // Você também pode tratar o erro de alguma forma, como registrar logs ou retornar uma mensagem de erro para o usuário.
        }

        return response()->json(['message' => 'Dados Excluido com sucesso!'], 200);
    }
}
