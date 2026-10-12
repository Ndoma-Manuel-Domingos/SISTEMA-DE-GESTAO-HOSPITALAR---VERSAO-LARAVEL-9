<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fornecedore extends Model
{

    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nif',
        'nome',
        'conta',
        'code',
        'morada',
        'codigo_postal',
        'localidade',
        'pais',
        'status',
        'telefone',
        'telemovel',
        'tipo_fornecedor',
        'tipo_pessoa',
        'email',
        'website',
        'pertence_id',
        'conta_id',
        'saldo',
        'observacao',
        'subconta_id',
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
