<?php

namespace App\Http\Controllers\Odontologia;

use App\Http\Controllers\Controller;
use App\Http\Requests\Odontologia\ProcedimentoOdontologicoRequest;
use App\Models\ProcedimentoOdontologico;
use Illuminate\Http\Request;

class ProcedimentoOdontologicoController extends Controller
{

    public function index(Request $request)
    {
        $pesquisa = $request->pesquisa;

        $procedimentos = ProcedimentoOdontologico::when(
            $pesquisa,
            function ($query) use ($pesquisa) {
                $query->where(function ($q) use ($pesquisa) {
                    $q->where('nome', 'like', "%{$pesquisa}%")
                        ->orWhere(
                            'codigo',
                            'like',
                            "%{$pesquisa}%"
                        );
                });
            }
        )
            ->orderBy('nome')
            ->paginate(15)
            ->withQueryString();

        return view('dashboard.odontologia.procedimentos.index', compact('procedimentos'));
    }

    public function create()
    {
        return view('dashboard.odontologia.procedimentos.create');
    }

    public function store(ProcedimentoOdontologicoRequest $request)
    {
        ProcedimentoOdontologico::create($request->validated());

        return redirect()->route('odontologia.procedimentos.index')
            ->with('success', 'Procedimento cadastrado com sucesso.');
    }

    public function show(ProcedimentoOdontologico $procedimento)
    {
        return view('dashboard.odontologia.procedimentos.show',  [
            'procedimento' => $procedimento
        ]);
    }

    public function edit(ProcedimentoOdontologico $procedimento)
    {
        return view('dashboard.odontologia.procedimentos.edit',            [
            'procedimento' => $procedimento
        ]);
    }

    public function update(ProcedimentoOdontologicoRequest $request,  ProcedimentoOdontologico $procedimento)
    {
        $procedimento->update($request->validated());

        return redirect()
            ->route('odontologia.procedimentos.index')
            ->with('success', 'Procedimento atualizado.');
    }

    public function destroy(ProcedimentoOdontologico $procedimento)
    {
        $procedimento->delete();

        return redirect()
            ->back()
            ->with('success', 'Procedimento removido.');
    }
}
