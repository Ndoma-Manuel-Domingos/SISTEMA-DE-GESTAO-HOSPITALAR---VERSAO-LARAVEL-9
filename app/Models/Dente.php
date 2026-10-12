<?php

namespace App\Models;

use App\Models\Odontologia\DenteSvg;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dente extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_denticao_id',
        'codigo_fdi',
        'nome',
        'quadrante',
        'lado',
        'sexo',
        'imagem_svg',
        'ordem',
        'arcada',
        'svg_id',
        'ativo'
    ];


    protected $casts = [
        'ativo' => 'boolean'
    ];

    public function tipoDenticao()
    {
        return $this->belongsTo(TipoDenticao::class);
    }

    public function odontogramas()
    {
        return $this->hasMany(Odontograma::class);
    }

    public function svg()
    {
        return $this->hasOne(DenteSvg::class);
    }
}
