<?php

namespace App\Http\Requests\Odontologia;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EstadoDenteRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        $id = $this->route('estado_dente');

        return [

            'nome' => [
                'required',
                'string',
                'max:100',
                Rule::unique(
                    'estados_dentes',
                    'nome'
                )->ignore($id)
            ],


            'cor' => [
                'required',
                'regex:/^#[a-fA-F0-9]{6}$/'
            ],


            'icone' => [
                'nullable',
                'string',
                'max:100'
            ],


            'descricao' => [
                'nullable',
                'string'
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
            'nome.required' => 'Informe o nome do estado.',
            'nome.unique' => 'Este estado já existe.',
            'cor.regex' => 'Informe uma cor hexadecimal válida. Exemplo: #FF0000'
        ];
    }
}
