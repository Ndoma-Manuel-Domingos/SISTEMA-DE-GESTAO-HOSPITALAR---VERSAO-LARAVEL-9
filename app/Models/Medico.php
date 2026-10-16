<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTime;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medico extends Model
{
    use HasFactory;
    use SoftDeletes;

    // Especificando o nome da tabela
    protected $table = 'medicos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'numero_cedula',
        'entidade_registradora',
        'provincia_registro',
        'gestor_conta',
        'data_emissao_cedula',
        'data_validade_cedula',
        'status_profissional',
        'saldo',
        'tipo_comissao',
        'valor_comissao',
        'tipo',
        'user_id',
        'funcionario_id',
        'especialidade_id',
        'entidade_id',
    ];

    public function my_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'gestor_conta', 'id');
    }

    public function comissoes(): HasMany
    {
        return $this->hasMany(MedicoComissao::class, 'medico_id', 'id');
    }

    public function pagamentos(): HasMany
    {
        return $this->hasMany(AgentePagamento::class, 'medico_id', 'id');
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



    public function disponibilidades()
    {
        return $this->hasMany(DisponibilidadeMedica::class, 'medico_id', 'id');
    }

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'funcionario_id', 'id');
    }

    public function especialidade()
    {
        return $this->belongsTo(Especialidade::class, 'especialidade_id', 'id');
    }

    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'provincia_registro', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
