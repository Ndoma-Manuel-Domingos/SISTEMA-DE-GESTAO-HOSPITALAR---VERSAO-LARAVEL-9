<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveTranscricaoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'consulta_id' => [
                'required',
                'exists:consultas,id'
            ],
            'tipo' => [
                'nullable',
                'in:paciente,medico'
            ],
            'texto' => [
                'required',
                'string'
            ],

            'segmento_audio' => [
                'nullable',
                'integer'
            ]
        ];
    }
}
