<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RelatorioHospitalController extends Controller
{
    public function index()
    {
        $entidade = User::with(['empresa'])->findOrFail(Auth::user()->id);
        
        $categorias = Categoria::where('entidade_id', $entidade->empresa->id)->get();

        $empresa_logada = User::with(["empresa.empresa_modulos", "empresa.tipo_entidade.modulos"])->findOrFail(Auth::user()->id);
      
        return view('dashboard.relatorios.hospital', compact('empresa_logada', 'categorias'));
    }

    public function dados(Request $request)
    {
        $entidade = User::with(['empresa'])->findOrFail(Auth::user()->id);

        $inicio = $request->input('inicio',now()->toDateString());
        $fim = $request->input('fim',now()->toDateString());
        $categoriaId = $request->input('categoria_id');

        try {
            $dataInicio = Carbon::createFromFormat('Y-m-d',$inicio)->startOfDay();
            $dataFim = Carbon::createFromFormat('Y-m-d',$fim)->endOfDay();
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Informe um intervalo de datas válido.'
            ], 422);
        }

        if ( $dataInicio->format('Y-m-d') !== $inicio || $dataFim->format('Y-m-d') !== $fim || $dataInicio->gt($dataFim)) {
            return response()->json([
                'message' => 'O intervalo de datas é inválido.'
            ], 422);
        }

        $base = DB::table('itens_vendas as iv')
            ->join('produtos as p', 'p.id', '=', 'iv.produto_id')
            ->leftJoin('categorias as c', 'c.id', '=', 'p.categoria_id')
            ->whereBetween('iv.created_at', [
                $dataInicio,
                $dataFim
            ])
            ->where('iv.entidade_id', $entidade->empresa->id)
            ->whereIn('iv.status', ['realizado']);

        if (!empty($categoriaId)) {
            $base->where('p.categoria_id', $categoriaId);
        }

        // Produtos mais solicitados/vendidos.
        $produtos = (clone $base)
            ->select( 'p.id', 'p.nome', DB::raw('COUNT(*) as quantidade'), DB::raw('SUM(iv.preco_unitario) as faturacao'))
            ->groupBy('p.id', 'p.nome')
            ->orderByDesc('quantidade')
            ->limit(10)
            ->get();

        // Distribuição por categoria: consultas, exames, etc.
        $categorias = (clone $base)
            ->select(
                DB::raw("COALESCE(c.categoria, 'Sem categoria') as categoria"),
                DB::raw('COUNT(*) as quantidade'),
                DB::raw('SUM(iv.preco_unitario) as faturacao')
            )
            ->groupBy('c.id', 'c.categoria')
            ->orderByDesc('quantidade')
            ->get();

        // Evolução diária.
        $evolucao = (clone $base)
            ->select(
                DB::raw('DATE(iv.created_at) as dia'),
                DB::raw('COUNT(*) as quantidade'),
                DB::raw('SUM(iv.preco_unitario) as faturacao')
            )
            ->groupBy(DB::raw('DATE(iv.created_at)'))
            ->orderBy('dia')
            ->get();

        return response()->json([
            'total_vendas' => (clone $base)->count(),
            'faturacao' => (float) (clone $base)->sum('iv.preco_unitario'),
            'produtos' => $produtos,
            'categorias' => $categorias,
            'evolucao' => $evolucao,
        ]);
    }
}