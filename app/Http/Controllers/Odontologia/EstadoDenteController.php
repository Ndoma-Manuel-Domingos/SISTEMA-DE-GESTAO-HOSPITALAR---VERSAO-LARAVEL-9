<?php

namespace App\Http\Controllers\Odontologia;


use App\Http\Controllers\Controller;
use App\Http\Requests\Odontologia\EstadoDenteRequest;
use App\Models\EstadoDente;
use Illuminate\Http\Request;

class EstadoDenteController extends Controller
{
    public function index(Request $request)
    {
        $pesquisa = $request->pesquisa;

        $estados = EstadoDente::when(
            $pesquisa,
            function ($query) use ($pesquisa) {
                $query->where('nome', 'like', "%{$pesquisa}%");
            }
        )
            ->orderBy('nome')
            ->paginate(15)
            ->withQueryString();

        return view('odontologia.estados_dentes.index', compact('estados'));
    }

    public function create()
    {
        return view('odontologia.estados_dentes.create');
    }

    public function store(EstadoDenteRequest $request)
    {
        EstadoDente::create($request->validated());

        return redirect()
            ->route('odontologia.estados-dentes.index')
            ->with('success', 'Estado cadastrado com sucesso.');
    }

    public function show(EstadoDente $estado_dente)
    {
        return view('odontologia.estados_dentes.show', [
            'estado' => $estado_dente
        ]);
    }

    public function edit(EstadoDente $estado_dente)
    {
        return view('odontologia.estados_dentes.edit',            [
            'estado' => $estado_dente
        ]);
    }

    public function update(EstadoDenteRequest $request, EstadoDente $estado_dente)
    {
        $estado_dente->update($request->validated());

        return redirect()
            ->route('odontologia.estados-dentes.index')
            ->with('success', 'Estado atualizado.');
    }

    public function destroy(EstadoDente $estado_dente)
    {
        $estado_dente->delete();
        return redirect()
            ->back()
            ->with('success', 'Estado removido.');
    }
}
