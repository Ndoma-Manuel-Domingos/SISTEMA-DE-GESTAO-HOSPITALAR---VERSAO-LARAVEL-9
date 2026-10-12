<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgentePagamentoItem extends Model
{

    use HasFactory;
    use SoftDeletes;

    // Especificando o nome da tabela
    protected $table = 'agentes_pagamentos_item';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'agente_pagamento_id',
        'comissao_id',
        'valor',
        'user_id',
        'entidade_id',
    ];

    public function comissao()
    {
        return $this->belongsTo(AgenteComissao::class, 'comissao_id', 'id');
    }

    public function pagamento()
    {
        return $this->belongsTo(AgentePagamento::class, 'agente_pagamento_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function entidade()
    {
        return $this->belongsTo(Entidade::class, 'entidade_id', 'id');
    }
}
