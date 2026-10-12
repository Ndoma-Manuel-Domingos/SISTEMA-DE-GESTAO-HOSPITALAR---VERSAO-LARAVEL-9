<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgentePagamento extends Model
{

    use HasFactory;
    use SoftDeletes;

    // Especificando o nome da tabela
    protected $table = 'agentes_pagamentos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'agente_id',
        'referencia',
        'numero',
        'data_at',
        'observacao',
        'quantidade',
        'forma_pagamento_id',
        'total',
        'user_id',
        'entidade_id',
    ];


    protected $casts = [
        'data_at' => 'date'
    ];

    public function agente()
    {
        return $this->belongsTo(Fornecedore::class, 'agente_id', 'id');
    }

    public function forma_pagamento()
    {
        return $this->belongsTo(TipoPagamento::class, 'forma_pagamento_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(AgentePagamentoItem::class, 'agente_pagamento_id', 'id');
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
