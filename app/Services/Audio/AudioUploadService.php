<?php

namespace App\Services\Audio;

use App\Models\ConsultaAudio;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AudioUploadService
{

    public function save($request)
    {
        $consulta = $request->consulta_id;
        $file = $request->file('audio');
        $folder = "consultas/" . date('Y') . "/" . date('m') . "/" . $consulta;

        $filename = Str::uuid() . ".webm";

        $path = $file->storeAs($folder, $filename, 'private');

        $entidade = User::with(['empresa'])->findOrFail(Auth::user()->id);

        return ConsultaAudio::create([
            'user_id' => Auth::user()->id,
            'entidade_id' => $entidade->empresa->id,
            'consulta_id' => $consulta,
            'nome_original' => $file->getClientOriginalName(),
            'nome_servidor' => $path,
            'mime_type' => $file->getMimeType(),
            'tamanho' => $file->getSize(),
            'codec' => $request->mime,
            'transcrito' => false,
            'gravacao_iniciada' => now()
        ]);
    }
}
