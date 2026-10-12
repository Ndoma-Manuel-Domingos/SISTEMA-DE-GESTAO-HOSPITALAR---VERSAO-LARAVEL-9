<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcedimentoOdontologico extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'procedimentos_odontologicos';

    protected $fillable = [
        'nome',
        'codigo',
        'descricao',
        'duracao',
        'valor',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'valor' => 'decimal:2'
    ];
}
