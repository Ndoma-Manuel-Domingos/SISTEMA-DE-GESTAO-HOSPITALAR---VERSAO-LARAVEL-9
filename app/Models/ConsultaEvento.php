<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultaEvento extends Model
{
    use HasFactory;
    use SoftDeletes;
    // Especificando o nome da tabela
    protected $table = 'consulta_entidades';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "consulta_id",
        "evento",
        "descricao",
        "ip",
        "dados",
        "user_agent",
        "user_id",
        "entidade_id",
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
