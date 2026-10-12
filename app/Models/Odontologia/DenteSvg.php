<?php

namespace App\Models\Odontologia;

use App\Models\Dente;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DenteSvg extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dentes_svg';

    protected $fillable = [
        'dente_id',
        'arquivo_svg',
        'svg_id',
        'conteudo_svg',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean'
    ];

    public function dente()
    {
        return $this->belongsTo(Dente::class);
    }
}
