<?php

namespace App\Http\Requests\Odontologia;

use Illuminate\Foundation\Http\FormRequest;

class DenteSvgRequest extends FormRequest
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
            'dente_id' => [
                'required',
                'exists:dentes,id'
            ],
            'arquivo_svg' => [
                'required',
                'file',
                'mimes:svg',
                'max:2048'
            ],
            'svg_id' => [
                'nullable',
                'string',
                'max:100'
            ],
            'ativo' => [
                'nullable',
                'boolean'
            ]
        ];
    }
}
