<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoDenticaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => 'required|max:100|unique:tipo_denticoes,nome,' . ($this->tipo_denticao),
            'idade_inicial' => 'required|integer|min:0|max:120',
            'idade_final' => 'required|integer|min:0|max:120',
            'descricao' => 'nullable',
            'ativo' => 'nullable'
        ];
    }


    public function messages()
    {
        return [
            'nome.required' => 'Informe o nome.',
            'nome.max' => 'O nome deve ter no máximo 100 caracteres.',
            'nome.unique' => 'O nome informado já está em uso.',
            'idade_inicial.required' => 'Informe a idade inicial.',
            'idade_final.required' => 'Informe a idade final.'
        ];
    }
}
