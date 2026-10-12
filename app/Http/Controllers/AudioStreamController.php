<?php

namespace App\Http\Controllers;

use App\Models\AudioAccessLog;
use App\Models\ConsultaAudio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AudioStreamController extends Controller
{

    public function play(string $id)
    {
        $audio = ConsultaAudio::findOrFail($id);


        $this->authorize('view', $audio);

        $entidade = User::with(['empresa'])->findOrFail(Auth::user()->id);

        /*  Aqui futuramente entra     a validação de permissões     */
        AudioAccessLog::create([
            'consulta_audio_id' => $audio->id,
            'user_id' =>  auth()->id(),
            'acao' =>  'reproducao_audio',
            'ip' =>  request()->ip(),
            'user_agent' =>  request()->userAgent(),
            'entidade_id' => $entidade->empresa->id,
        ]);



        if (!Storage::disk('private')->exists($audio->nome_servidor)) {
            abort(404, "Áudio não encontrado");
        }


        $file = Storage::disk('private')->get($audio->nome_servidor);

        return response($file)->header(
            'Content-Type',
            $audio->mime_type
        );
    }
}
