<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadAudioRequest;
use App\Models\User;
use App\Services\Audio\AudioUploadService;
use Illuminate\Support\Facades\Auth;

class ConsultaAudioController extends Controller
{
    public function upload(UploadAudioRequest $request,  AudioUploadService $service)
    {
        $entidade = User::with(['empresa'])->findOrFail(Auth::user()->id);

        $audio = $service->save($request);
        return response()->json([
            "success" => true,
            "audio_id" => $audio->id,
            'user_id' => Auth::user()->id,
            'entidade_id' => $entidade->empresa->id,
        ]);
    }
}
