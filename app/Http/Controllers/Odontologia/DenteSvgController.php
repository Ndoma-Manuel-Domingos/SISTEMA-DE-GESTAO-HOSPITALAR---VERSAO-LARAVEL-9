<?php

namespace App\Http\Controllers\Odontologia;

use App\Http\Controllers\Controller;
use App\Http\Requests\Odontologia\DenteSvgRequest;
use App\Models\Dente;
use App\Models\Odontologia\DenteSvg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class DenteSvgController extends Controller
{
    /**
     * Lista SVG cadastrados
     */
    public function index(Request $request)
    {
        $pesquisa = $request->pesquisa;
        $svgs = DenteSvg::with('dente')
            ->when($pesquisa, function ($query) use ($pesquisa) {
                $query->whereHas('dente', function ($q) use ($pesquisa) {
                    $q->where('codigo_fdi', 'like', "%{$pesquisa}%")
                        ->orWhere('nome', 'like', "%{$pesquisa}%");
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view(
            'odontologia.dentes_svg.index',
            compact('svgs')
        );
    }

    /**
     * Formulário cadastro
     */
    public function create()
    {
        $dentes = ModelsDente::orderBy('codigo_fdi')->get();

        return view(
            'odontologia.dentes_svg.create',
            compact('dentes')
        );
    }

    /**
     * Salvar SVG
     */
    public function store(
        DenteSvgRequest $request
    ) {
        $dados = $request->validated();
        if ($request->hasFile('arquivo_svg')) {
            $arquivo = $request->file('arquivo_svg');
            $path = $arquivo->store(
                'svg/dentes',
                'public'
            );
            /*
            Lê conteúdo SVG
            */

            $conteudo = file_get_contents(
                $arquivo->getRealPath()
            );

            $dados['arquivo_svg'] = $path;
            $dados['conteudo_svg'] = $conteudo;
            /*
            Tenta encontrar id do SVG
            Ex:
            <path id="11">
            */
            if (
                preg_match(
                    '/id="([^"]+)"/',
                    $conteudo,
                    $match
                )
            ) {

                $dados['svg_id'] = $match[1];
            }
        }

        DenteSvg::create($dados);

        return redirect()
            ->route(
                'odontologia.dentes-svg.index'
            )
            ->with(
                'success',
                'SVG cadastrado com sucesso.'
            );
    }

    /**
     * Visualizar
     */
    public function show(DenteSvg $denteSvg)
    {
        return view('odontologia.dentes_svg.show', [
            'svg' => $denteSvg
        ]);
    }





    /**
     * Editar
     */
    public function edit(DenteSvg $denteSvg)
    {
        $dentes = Dente::orderBy('codigo_fdi')->get();

        return view('odontologia.dentes_svg.edit', [
            'svg' => $denteSvg,
            'dentes' => $dentes
        ]);
    }


    /**
     * Atualizar
     */
    public function update(DenteSvgRequest $request,  DenteSvg $denteSvg)
    {
        $dados = $request->validated();
        if ($request->hasFile('arquivo_svg')) {
            if ($denteSvg->arquivo_svg) {
                Storage::disk('public')
                    ->delete(
                        $denteSvg->arquivo_svg
                    );
            }
            $arquivo = $request
                ->file('arquivo_svg');
            $path = $arquivo->store(
                'svg/dentes',
                'public'
            );
            $dados['arquivo_svg'] = $path;
            $dados['conteudo_svg'] = file_get_contents($arquivo->getRealPath());
        }

        $denteSvg->update($dados);
        return redirect()
            ->route(
                'odontologia.dentes-svg.index'
            )
            ->with(
                'success',
                'SVG atualizado.'
            );
    }

    /**
     * Remover
     */
    public function destroy(DenteSvg $denteSvg)
    {
        if ($denteSvg->arquivo_svg) {
            Storage::disk('public')
                ->delete(
                    $denteSvg->arquivo_svg
                );
        }
        $denteSvg->delete();

        return back()
            ->with(
                'success',
                'SVG removido.'
            );
    }
}
