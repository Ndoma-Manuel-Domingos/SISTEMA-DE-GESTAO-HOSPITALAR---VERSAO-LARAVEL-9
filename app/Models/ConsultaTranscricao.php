<?php

namespace App\Models;

use App\Enums\TipoTranscricao;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultaTranscricao extends Model
{
    use HasFactory;
    use SoftDeletes;
    // Especificando o nome da tabela
    protected $table = 'consulta_transcricoes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "consulta_id",
        "texto",
        "segmento_audio",
        "momento",
        "user_id",
        'texto_original',
        'texto_processado',
        'tipo',
        'inicio_segundo',
        'fim_segundo',
        "entidade_id",
    ];

    protected $casts = [
        'momento' => 'datetime',
        'tipo' => TipoTranscricao::class
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class, 'consulta_id', 'id');
    }

    public function entidade()
    {
        return $this->belongsTo(Entidade::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
