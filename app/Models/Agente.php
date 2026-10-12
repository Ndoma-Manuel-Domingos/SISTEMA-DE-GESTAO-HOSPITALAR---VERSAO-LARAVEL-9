<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agente extends Model
{

    use HasFactory;
    use SoftDeletes;

    // Especificando o nome da tabela
    protected $table = 'agentes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nif',
        'nome',
        'status',  // 'activo','suspenso','desactivo'
        'genero',
        'estado_civil_id',
        'morada',
        'telefone',
        'saldo',
        'email',
        'pertence_id',
        'conta_id',
        'user_id',
        'entidade_id',
    ];

    public function comissoes()
    {
        return $this->hasMany(AgenteComissao::class, 'agente_id', 'id');
    }

    public function pagamentos()
    {
        return $this->hasMany(AgentePagamento::class, 'agente_id', 'id');
    }


    public function comissoes_pendente()
    {
        return $this->commissoes()->where('status', false);
    }

    public function comissoes_pagas()
    {
        return $this->commissoes()->where('status', true);
    }

    public function total_commissoes_pendente()
    {
        return $this->comissoes_pendente()->sum('valor');
    }

    public function total_comissoes_pagas()
    {
        return $this->comissoes_pagas()->sum('valor');
    }

    public function totalClientes()
    {
        return $this->comissoes_pendente()->count();
    }

    public function atendimentos()
    {
        return $this->hasMany(Atendimento::class, 'agente_id', 'id');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoCivil::class, 'estado_civil_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function pertence()
    {
        return $this->belongsTo(Fornecedore::class, 'pertence_id', 'id');
    }

    public function conta()
    {
        return $this->belongsTo(User::class, 'conta_id', 'id');
    }

    public function entidade()
    {
        return $this->belongsTo(Entidade::class, 'entidade_id', 'id');
    }
}
