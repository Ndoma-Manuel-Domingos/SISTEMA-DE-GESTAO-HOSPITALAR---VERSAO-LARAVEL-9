<?php

namespace App\Services;

use App\Models\Caixa;
use App\Models\ContaBancaria;
use App\Models\OperacaoFinanceiro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OperacaoFinanceiraService
{
    /**
     * Regista uma operação financeira.
     */
    public function registar(array $dados): array
    {
        return DB::transaction(function () use ($dados) {
            $tipoPagamento = $dados['forma_pagamento'];
            $contas = $this->obterContas($tipoPagamento, $dados);
            // Validar saldo de todas as contas antes de criar operações.
            foreach ($contas as $conta) {
                $this->validarSaldo( $conta['modelo'], $conta['montante'], $dados['saldo_conta']);
            }
            $operacoes = [];
            foreach ($contas as $conta) {
                $operacoes[] = $this->criarOperacao( $dados, $conta);
            }
            return [
                'sucesso' => true,
                'operacoes' => $operacoes,
            ];
        });
    }

    /**
     * Identifica as contas e os montantes de cada forma de pagamento.
     */
    private function obterContas(string $tipo, array $dados): array
    {
        switch ($tipo) {
            case 'NU':
                return [
                    [
                        'modelo' => Caixa::findOrFail($dados['caixa_id']),
                        'montante' => $dados['montante_final'],
                        'forma' => 'C',
                    ],
                ];

            case 'MB':
            case 'DE':
            case 'TE':
                return [
                    [
                        'modelo' => ContaBancaria::findOrFail($dados['banco_id']),
                        'montante' => $dados['montante_final'],
                        'forma' => 'B',
                    ],
                ];

            case 'OU':
                return [
                    [
                        'modelo' => Caixa::findOrFail($dados['caixa_id']),
                        'montante' => $dados['montante_caixa'],
                        'forma' => 'C',
                    ],
                    [
                        'modelo' => ContaBancaria::findOrFail($dados['banco_id']),
                        'montante' => $dados['montante_banco'],
                        'forma' => 'B',
                    ],
                ];

            default:
                throw ValidationException::withMessages([
                    'forma_pagamento' => 'A forma de pagamento não é suportada.',
                ]);
        }
    }

    /**
     * Valida o saldo disponível.
     */
    private function validarSaldo( $conta, float $montante, callable $saldoConta): void 
    {
        $saldo = $saldoConta($conta->subconta_id);

        if ($montante > $saldo) {
            $tipoConta = $conta instanceof Caixa ? 'caixa' : 'conta bancária';

            throw ValidationException::withMessages([
                'saldo' => sprintf('Saldo insuficiente no %s: %s - %s. Saldo atual: %s.', $tipoConta, $conta->conta, $conta->nome, $saldo),
            ]);
        }
    }

    /**
     * Cria a operação financeira.
     */
    private function criarOperacao( array $dados, array $conta): OperacaoFinanceiro 
    {
        $modeloConta = $conta['modelo'];
        $userId = Auth::id();

        return OperacaoFinanceiro::create([
            'nome' => $dados['nome'],
            'status' => 'pago',
            'motante' => (float) $conta['montante'],
            'formas' => $conta['forma'],
            'parcelado' => null,
            'parcelas' => null,
            'cliente_id' => null,
            'fornecedor_id' => $dados['fornecedor_id'] ?? null,
            'code_caixa' => $modeloConta->code_caixa,
            'status_caixa' => 'pendente',
            'subconta_id' => $modeloConta->subconta_id,
            'model_id' => $dados['model_id'],
            'type' => 'D',
            'status_pagamento' => 'pago',
            'centro_custo_id' => $dados['centro_custo_id'] ?? null,
            'loja_id' => $dados['loja_id'] ?? null,
            'code' => $dados['code'],
            'descricao' => $dados['descricao'],
            'movimento' => 'S',
            'date_at' => $dados['date_at'],
            'user_id' => $userId,
            'user_open_id' => $userId,
            'comprovativo' => null,
            'entidade_id' => $dados['entidade_id'],
            'exercicio_id' => $dados['exercicio_id'],
            'periodo_id' => $dados['periodo_id'],
        ]);
    }
}
