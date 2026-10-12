<?php

namespace App\Http\Controllers\Odontologia;

use App\Http\Controllers\Controller;
use App\Http\Requests\TipoDenticaoRequest;
use App\Models\TipoDenticao;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TipoDenticaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $entidade = User::with(['empresa'])->findOrFail(Auth::user()->id);

        $pesquisa = $request->pesquisa;

        $tipos = TipoDenticao::when($pesquisa, function ($q) use ($pesquisa) {
            $q->where('nome', 'like', "%{$pesquisa}%");
        })
            ->orderBy('nome')
            ->paginate(10);

        return view('dashboard.odontologia.tipos_denticao.index', [
            "titulo" => "Tipos de Dentição",
            "descricao" => env("APP_NAME"),
            "tipos" => $tipos,
            "empresa_logada" => $entidade,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $entidade = User::with(['empresa'])->findOrFail(Auth::user()->id);

        return view('dashboard.odontologia.tipos_denticao.create', [
            "titulo" => "Tipos de Dentição",
            "descricao" => env("APP_NAME"),
            "empresa_logada" => $entidade,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TipoDenticaoRequest $request)
    {
        TipoDenticao::create([
            'nome' => $request->nome,
            'idade_inicial' => $request->idade_inicial,
            'idade_final' => $request->idade_final,
            'descricao' => $request->descricao,
            'ativo' => $request->has('ativo')
        ]);

        return redirect()->route('odontologia.tipo-denticao.index')->with('success', 'Registro criado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(TipoDenticao $tipos_denticao)
    {
        $entidade = User::with(['empresa'])->findOrFail(Auth::user()->id);

        return view('dashboard.odontologia.tipos_denticao.show', [
            'titulo' => 'Detalhes do Tipo de Dentição',
            'tipo' => $tipos_denticao,
            'empresa_logada' => $entidade
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoDenticao $tipoDenticao)
    {
        return view('dashboard.odontologia.tipos_denticao.edit', [
            'titulo' => 'Editar Tipo de Dentição',
            'tipo' => $tipoDenticao
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TipoDenticaoRequest $request, TipoDenticao $tipoDenticao)
    {
        $tipoDenticao->update([
            'nome' => $request->nome,
            'idade_inicial' => $request->idade_inicial,
            'idade_final' => $request->idade_final,
            'descricao' => $request->descricao,
            'ativo' => $request->has('ativo')
        ]);

        return redirect()->route('odontologia.tipos-denticao.index')->with('success', 'Atualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoDenticao $tipoDenticao)
    {
        $tipoDenticao->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
