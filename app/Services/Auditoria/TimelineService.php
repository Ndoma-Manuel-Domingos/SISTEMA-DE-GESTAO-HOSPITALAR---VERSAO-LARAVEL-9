<?php

namespace App\Services\Auditoria;

use App\Models\ConsultaEvento;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TimelineService
{

    public function registrar(int $consulta, string $evento, ?string $descricao = null, array $dados = []): void
    {
        $entidade = User::with(['empresa'])->findOrFail(Auth::user()->id);

        ConsultaEvento::create([
            'consulta_id' => $consulta,
            'user_id' => auth()->id(),
            'evento' => $evento,
            'descricao' => $descricao,
            'dados' => $dados,
            'ip' => request()->ip(),
            'entidade_id' => $entidade->empresa->id,
            'user_agent' => request()->userAgent()
        ]);
    }
}
