<?php

use App\Http\Controllers\Odontologia\DashboardController;
use App\Http\Controllers\Odontologia\DenteController;
use App\Http\Controllers\Odontologia\DenteSvgController;
use App\Http\Controllers\Odontologia\EstadoDenteController;
use App\Http\Controllers\Odontologia\OdontogramaController;
use App\Http\Controllers\Odontologia\ProcedimentoOdontologicoController;
use App\Http\Controllers\Odontologia\TipoDenticaoController;

use Illuminate\Support\Facades\Route;

Route::prefix('odontologia')->name('odontologia.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/tipos-denticao', TipoDenticaoController::class);
    Route::resource('/dentes', DenteController::class);
    Route::resource('dentes-svg', DenteSvgController::class);
    Route::resource('/estados-dentes', EstadoDenteController::class);
    Route::resource('/procedimentos', ProcedimentoOdontologicoController::class);

    Route::get('odontograma/dente/{codigo}', [OdontogramaController::class, 'buscarDente'])->name('odontograma.buscar-dente');
    Route::get('odontograma/estado-atual',  [OdontogramaController::class, 'estadoAtual'])->name('odontograma.estado-atual');
});
