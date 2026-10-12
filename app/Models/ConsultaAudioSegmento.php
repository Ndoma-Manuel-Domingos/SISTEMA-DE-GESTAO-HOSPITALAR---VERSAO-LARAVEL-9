<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultaAudioSegmento extends Model
{
    use HasFactory;
    use SoftDeletes;
    // Especificando o nome da tabela
    protected $table = 'consulta_audio_segmentos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "consulta_id",
        'consulta_audio_id',
        'ordem',
        'ficheiro',
        'duracao',
        'mime_type',
        'tamanho',
        "user_id",
        "entidade_id",
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class, 'consulta_id', 'id');
    }

    public function audio()
    {
        return $this->belongsTo(ConsultaAudio::class, 'consulta_audio_id', 'id');
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
