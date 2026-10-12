<?php

namespace App\Http\Requests\Odontologia;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProcedimentoOdontologicoRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('procedimento_odontologico');
        return [
            'nome' => [
                'required',
                'string',
                'max:150'
            ],
            'codigo' => [
                'required',
                'string',
                'max:20',
                Rule::unique(
                    'procedimentos_odontologicos',
                    'codigo'
                )->ignore($id)
            ],
            'descricao' => [
                'nullable',
                'string'
            ],
            'duracao' => [
                'nullable',
                'integer',
                'min:1'
            ],
            'valor' => [
                'nullable',
                'numeric',
                'min:0'
            ],
            'ativo' => [
                'nullable',
                'boolean'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'Informe o nome do procedimento.',
            'codigo.required' => 'Informe o código do procedimento.',
            'codigo.unique' => 'Este código já está cadastrado.',
            'duracao.integer' => 'A duração deve ser informada em minutos.',
            'valor.numeric' => 'Informe um valor válido.'
        ];
    }
}
