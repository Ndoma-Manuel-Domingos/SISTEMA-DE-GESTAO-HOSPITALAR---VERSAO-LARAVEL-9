<?php

namespace App\Http\Controllers\Odontologia;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $entidade = User::with(['empresa'])->findOrFail(Auth::user()->id);

        return view('dashboard.odontologia.dashboard.dashboard', [
            "titulo" => "Odontologia",
            "descricao" => env("APP_NAME"),
            "empresa_logada" => $entidade,
        ]);
    }
}
