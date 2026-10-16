<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicoPagamento extends Model
{

    use HasFactory;
    use SoftDeletes;

    // Especificando o nome da tabela
    protected $table = 'medicos_pagamentos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'medico_id',
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

    public function medico(): BelongsTo
    {
        return $this->belongsTo(Medico::class, 'medico_id', 'id');
    }

    public function forma_pagamento()
    {
        return $this->belongsTo(TipoPagamento::class, 'forma_pagamento_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(MedicoPagamentoItem::class, 'medico_pagamento_id', 'id');
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
