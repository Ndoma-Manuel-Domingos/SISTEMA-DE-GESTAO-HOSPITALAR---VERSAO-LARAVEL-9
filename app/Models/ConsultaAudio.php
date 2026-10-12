<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultaAudio extends Model
{
    use HasFactory;
    use SoftDeletes;
    // Especificando o nome da tabela
    protected $table = 'consulta_audios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "consulta_id",
        "nome_original",
        "nome_servidor",
        "mime_type",
        "tamanho",
        "duracao",
        "idioma",
        "codec",
        "transcrito",
        "texto_transcrito",
        "gravacao_iniciada",
        "gravacao_finalizada",
        "user_id",
        "entidade_id",
    ];

    protected $casts = [
        'transcrito' => 'boolean',
        'gravacao_iniciada' => 'datetime',
        'gravacao_finalizada' => 'datetime'
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
