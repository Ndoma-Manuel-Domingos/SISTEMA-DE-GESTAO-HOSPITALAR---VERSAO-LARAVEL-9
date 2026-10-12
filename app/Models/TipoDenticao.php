<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDenticao extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'idade_inicial',
        'idade_final',
        'descricao',
        'ativo'
    ];


    protected $casts = [
        'ativo' => 'boolean'
    ];


    public function dentes()
    {
        return $this->hasMany(Dente::class);
    }
}
