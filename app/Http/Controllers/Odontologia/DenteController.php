<?php

namespace App\Http\Controllers\Odontologia;

use App\Http\Controllers\Controller;
use App\Http\Requests\DenteRequest;
use App\Models\Dente;
use App\Models\TipoDenticao;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DenteController extends Controller
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

        $dentes = Dente::when($pesquisa, function ($q) use ($pesquisa) {
            $q->where('nome', 'like', "%{$pesquisa}%");
        })
            ->orderBy('nome')
            ->paginate(10);

        return view('dashboard.odontologia.dentes.index', [
            "titulo" => "Dentes",
            "descricao" => env("APP_NAME"),
            "dentes" => $dentes,
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

        $tipos = TipoDenticao::get();

        return view('dashboard.odontologia.dentes.create', [
            "titulo" => "Dentes",
            "descricao" => env("APP_NAME"),
            "tipos" => $tipos,
            "empresa_logada" => $entidade,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DenteRequest $request)
    {
        Dente::create([
            'nome' => $request->nome,
            'idade_inicial' => $request->idade_inicial,
            'idade_final' => $request->idade_final,
            'descricao' => $request->descricao,
            'ativo' => $request->has('ativo')
        ]);

        return redirect()->route('odontologia.dentes.index')->with('success', 'Registro criado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Dente $dente)
    {
        $entidade = User::with(['empresa'])->findOrFail(Auth::user()->id);

        $dente->load('tipoDenticao');

        return view('dashboard.odontologia.dentes.show', [
            'titulo' => 'Detalhes do Dente',
            'dente' => $dente,
            'empresa_logada' => $entidade
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Dente $dente)
    {
        $tipos = TipoDenticao::get();

        return view('dashboard.odontologia.dentes.edit', [
            'titulo' => 'Editar Dente',
            'dente' => $dente,
            "tipos" => $tipos,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DenteRequest $request, Dente $dente)
    {
        $dente->update([
            'nome' => $request->nome,
            'idade_inicial' => $request->idade_inicial,
            'idade_final' => $request->idade_final,
            'descricao' => $request->descricao,
            'ativo' => $request->has('ativo')
        ]);

        return redirect()->route('odontologia.dentes.index')->with('success', 'Atualizado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dente $dente)
    {
        $dente->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
