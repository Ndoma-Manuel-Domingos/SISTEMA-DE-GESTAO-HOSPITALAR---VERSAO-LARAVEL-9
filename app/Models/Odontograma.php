<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Odontograma extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'odontogramas';

    protected $fillable = [
        'paciente_id',
        'dente_id',
        'estado_dente_id',
        'procedimento_id',
        'observacao',
        'user_id'
    ];

    public function dente()
    {
        return $this->belongsTo(Dente::class);
    }

    public function estado()
    {
        return $this->belongsTo(EstadoDente::class, 'estado_dente_id');
    }


    public function procedimento()
    {
        return $this->belongsTo(ProcedimentoOdontologico::class, 'procedimento_id');
    }
}
