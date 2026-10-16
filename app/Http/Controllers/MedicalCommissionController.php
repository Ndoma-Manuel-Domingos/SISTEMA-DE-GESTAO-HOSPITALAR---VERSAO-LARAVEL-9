<?php

namespace App\Http\Controllers;

use App\Models\MedicalCommission;
use App\Models\MedicalCommissionRule;
use App\Models\MedicalCommissionPayment;
use App\Models\MedicalCommissionPaymentItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class MedicalCommissionController extends Controller
{
    private function serviceTypes(): array
    {
        return [
            'consulta' => 'Consulta',
            'tratamento' => 'Tratamento',
            'internamento' => 'Internamento',
            'outro' => 'Outro serviço',
        ];
    }

    /**
     * Listagem e filtros.
     */
    public function index(Request $request)
    {
        $request->validate([
            'doctor_id' => ['nullable', 'integer', 'min:1'],
            'service_type' => [ 'nullable', Rule::in(array_keys($this->serviceTypes())),],
            'data_inicio' => ['nullable', 'date'],
            'data_fim' => [ 'nullable', 'date', 'after_or_equal:data_inicio',],
            'estado' => [ 'nullable', Rule::in(['pendente', 'parcial', 'pago']),],
        ]);

        $entidade = User::with(['empresa'])->findOrFail(Auth::user()->id);
      

        $query = MedicalCommission::query()
            ->withSum('paymentItems as paid_total', 'amount')
            ->when($request->filled('doctor_id'), function ($q) use ($request) {
                $q->where('doctor_id', $request->doctor_id);
            })
            ->when($request->filled('service_type'), function ($q) use ($request) {
                $q->where('service_type', $request->service_type);
            })
            ->when($request->filled('data_inicio'), function ($q) use ($request) {
                $q->whereDate('service_date', '>=', $request->data_inicio);
            })
            ->when($request->filled('data_fim'), function ($q) use ($request) {
                $q->whereDate('service_date', '<=', $request->data_fim);
            });

        $comissoes = $query
            ->orderByDesc('service_date')
            ->orderByDesc('id')
            ->get()
            ->map(function ($comissao) {
                $pago = (float) ($comissao->paid_total ?? 0);
                $comissao->valor_pago = $pago;
                $comissao->saldo = max( 0, round((float) $comissao->commission_amount - $pago, 2));
                $comissao->estado_pagamento = $pago <= 0 ? 'pendente' : ($comissao->saldo <= 0 ? 'pago' : 'parcial');
                return $comissao;
            });

        if ($request->filled('estado')) {
            $comissoes = $comissoes ->where('estado_pagamento', $request->estado) ->values();
        }
        $totalComissoes = round( $comissoes->sum('commission_amount'), 2);
        $totalPago = round( $comissoes->sum('valor_pago'), 2);
        $totalPendente = round( $comissoes->sum('saldo'), 2);

        // Médicos existentes nas comissões.
        $medicos = MedicalCommission::query()
            ->select('doctor_id')
            ->distinct()
            ->orderBy('doctor_id')
            ->pluck('doctor_id');

        return view('dashboard.medical-commissions.index', [
            'comissoes' => $comissoes,
            'medicos' => $medicos,
            'serviceTypes' => $this->serviceTypes(),
            'totalComissoes' => $totalComissoes,
            'totalPago' => $totalPago,
            'totalPendente' => $totalPendente,
            'filtros' => $request->only([
                'doctor_id',
                'service_type',
                'data_inicio',
                'data_fim',
                'estado',
            ]),
            "empresa_logada" => User::with(['empresa.empresa_modulos', 'empresa.tipo_entidade'])->findOrFail(Auth::user()->id),
        ]);
    }

    /**
     * Listagem das regras.
     */
    public function rules()
    {
        $regras = MedicalCommissionRule::query()
            ->orderBy('doctor_id')
            ->orderBy('service_type')
            ->get();

        return view('dashboard.medical-commissions.rules', [
            'regras' => $regras,
            'serviceTypes' => $this->serviceTypes(),
            "empresa_logada" => User::with(['empresa.empresa_modulos', 'empresa.tipo_entidade'])->findOrFail(Auth::user()->id),
        ]);
    }

    /**
     * Criar uma regra de comissão.
     */
    public function storeRule(Request $request)
    {
        $dados = $request->validate([
            'doctor_id' => ['required', 'integer', 'min:1'],
            'service_type' => [ 'required', Rule::in(array_keys($this->serviceTypes())),],
            'commission_type' => [ 'required', Rule::in(['percentage', 'fixed']),],
            'commission_value' => [ 'required', 'numeric', 'min:0.01', 'max:9999999999999.99',],
        ]);

        if ( $dados['commission_type'] === 'percentage' && (float) $dados['commission_value'] > 100) {
            throw ValidationException::withMessages([
                'commission_value' => 'A percentagem não pode ultrapassar 100%.',
            ]);
        }

        MedicalCommissionRule::updateOrCreate([
            'doctor_id' => $dados['doctor_id'],
            'service_type' => $dados['service_type'],
            "entidade_id" => Auth::user()->entidade_id,
        ], [
            'commission_type' => $dados['commission_type'],
            'commission_value' => $dados['commission_value'],
            'active' => true,
            'user_id' => Auth::user()->id,
        ]);

        return redirect()
            ->route('medical-commissions.rules')
            ->with('success', 'Regra de comissão guardada com sucesso.');
    }

    /**
     * Ativar/desativar uma regra.
     */
    public function toggleRule(MedicalCommissionRule $rule)
    {
        $rule->active = !$rule->active;
        $rule->save();

        return back()->with(
            'success',
            'Estado da regra atualizado com sucesso.'
        );
    }

    /**
     * Registar um pagamento total ou parcial.
     */
    public function pay(Request $request)
    {
        $dados = $request->validate([
            'doctor_id' => ['required', 'integer', 'min:1'],
            'amount' => ['required', 'numeric', 'gt:0', 'max:9999999999999.99'],
            'payment_method' => [
                'required',
                Rule::in(['dinheiro', 'transferencia', 'multicaixa', 'outro']),
            ],
            'reference' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'paid_at' => ['required', 'date'],
        ]);

        $payment = DB::transaction(function () use ($dados) {
            // Bloqueia as comissões do médico durante a distribuição.
            $comissoes = MedicalCommission::query()
                ->where('doctor_id', $dados['doctor_id'])
                ->orderBy('service_date')
                ->orderBy('id')
                ->lockForUpdate()
                ->get();

            $ids = $comissoes->pluck('id');

            $pagamentosAnteriores = MedicalCommissionPaymentItem::query()
                ->whereIn('commission_id', $ids)
                ->select('commission_id', DB::raw('SUM(amount) as total_pago'))
                ->groupBy('commission_id')
                ->pluck('total_pago', 'commission_id');

            $saldoDisponivel = 0;

            foreach ($comissoes as $comissao) {
                $pago = (float) ($pagamentosAnteriores[$comissao->id] ?? 0);

                $saldoDisponivel += max(
                    0,
                    round((float) $comissao->commission_amount - $pago, 2)
                );
            }

            $valorPagamento = round((float) $dados['amount'], 2);
            $saldoDisponivel = round($saldoDisponivel, 2);

            if ($valorPagamento > $saldoDisponivel) {
                throw ValidationException::withMessages([
                    'amount' => 'O valor ultrapassa o saldo de comissões por pagar.',
                ]);
            }

            $payment = MedicalCommissionPayment::create([
                'doctor_id' => $dados['doctor_id'],
                'amount' => $valorPagamento,
                'payment_method' => $dados['payment_method'],
                'reference' => $dados['reference'] ?? null,
                'notes' => $dados['notes'] ?? null,
                'paid_at' => $dados['paid_at'],
                'user_id' => auth()->id(),
            ]);

            $restante = $valorPagamento;

            foreach ($comissoes as $comissao) {
                if ($restante <= 0) {
                    break;
                }

                $jaPago = (float) (
                    $pagamentosAnteriores[$comissao->id] ?? 0
                );

                $saldo = max(
                    0,
                    round((float) $comissao->commission_amount - $jaPago, 2)
                );

                if ($saldo <= 0) {
                    continue;
                }

                $valorAplicar = min($restante, $saldo);

                MedicalCommissionPaymentItem::create([
                    'payment_id' => $payment->id,
                    'commission_id' => $comissao->id,
                    'amount' => $valorAplicar,
                ]);

                $restante = round($restante - $valorAplicar, 2);
            }

            if ($restante > 0) {
                throw ValidationException::withMessages([
                    'amount' => 'Não foi possível distribuir todo o pagamento.',
                ]);
            }

            return $payment;
        }, 3);

        return redirect()
            ->route('medical-commissions.index', [
                'doctor_id' => $dados['doctor_id'],
            ])
            ->with('success', 'Pagamento registado com sucesso. Referência interna: '.$payment->id);
    }
}