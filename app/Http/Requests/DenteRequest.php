<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DenteRequest extends FormRequest
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
            'nome' => 'required|max:150',
            'codigo_fdi' => 'required|max:2',
            'arcada' => 'required',
            'lado' => 'required',
            'quadrante' => 'required',
            'tipo_denticao_id' => 'required|exists:tipo_denticoes,id',
            'sexo' => 'required',
            'ordem' => 'nullable|integer|min:0',
            'svg_id' => 'nullable|string',
            'imagem_svg' => 'nullable|string',
            'ativo' => 'boolean'
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'Informe o nome do dente.',
            'codigo_fdi.required' => 'Informe o código FDI do dente.',
            'arcada.required' => 'Informe a arcada do dente.',
            'lado.required' => 'Informe o lado do dente.',
            'quadrante.required' => 'Informe o quadrante do dente.',
            'tipo_denticao_id.required' => 'Informe o tipo de dentição do dente.',
            'tipo_denticao_id.exists' => 'O tipo de dentição informado não existe.',
            'sexo.required' => 'Informe o sexo do dente.'
        ];
    }
}
