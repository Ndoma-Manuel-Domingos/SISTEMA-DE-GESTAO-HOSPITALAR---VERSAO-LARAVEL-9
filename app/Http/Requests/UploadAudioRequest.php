<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadAudioRequest extends FormRequest
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
            'consulta_id' => ['required', 'exists:consultas,id'],
            'segment' => ['required', 'integer'],
            'uuid' => ['required', 'string', 'max:100'],
            'hash' => ['required', 'string'],
            'mime' => ['required'],
            'audio' => ['required', 'file', 'max:20480']
        ];
    }
}
