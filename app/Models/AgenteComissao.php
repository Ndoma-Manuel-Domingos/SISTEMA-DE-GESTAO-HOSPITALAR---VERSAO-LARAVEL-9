<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgenteComissao extends Model
{

    use HasFactory;
    use SoftDeletes;

    // Especificando o nome da tabela
    protected $table = 'agentes_comissoes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pago_em',
        'status',
        'agente_pagamento_id',
        'servico_id',
        'valor',
        'paciente_id',
        'agente_id',
        'user_id',
        'entidade_id',
    ];

    protected $casts = [
        'status' => 'boolean',
        'pago_em' => 'date'
    ];

    public function servico()
    {
        return $this->belongsTo(Produto::class, 'servico_id', 'id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'paciente_id', 'id');
    }

    public function pagamento()
    {
        return $this->belongsTo(AgentePagamento::class, 'agente_pagamento_id');
    }

    public function agente()
    {
        return $this->belongsTo(Fornecedore::class, 'agente_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function entidade()
    {
        return $this->belongsTo(Entidade::class, 'entidade_id', 'id');
    }

    public function pagamentoItem()
    {
        return $this->hasOne(AgentePagamentoItem::class, 'comissao_id', 'id');
    }

    public function scopePending($query)
    {
        return $query->where('status', false);
    }

    public function scopePaid($query)
    {
        return $query->where('status', true);
    }
}
