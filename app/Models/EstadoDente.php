<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstadoDente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'estado_dentes';
    protected $fillable = [
        'nome',
        'cor',
        'icone',
        'descricao',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean'
    ];
}
