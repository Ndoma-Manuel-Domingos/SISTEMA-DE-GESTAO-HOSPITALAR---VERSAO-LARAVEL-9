<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDemoAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:150',
            ],

            'email' => [
                'required',
                'string',
                'email:rfc,dns',
                'max:255',
            ],

            'phone' => [
                'required',
                'string',
                'min:9',
                'max:30',
                'regex:/^\+?[0-9\s\-\(\)]+$/',
            ],

            'software' => [
                'required',
                'string',
                'min:2',
                'max:150',
            ],

            'demo_date' => [
                'required',
                'date_format:Y-m-d',
                'after_or_equal:today',
            ],

            'demo_time' => [
                'required',
                'date_format:H:i',
            ],

            'message' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser um texto.',
            'name.min' => 'O nome deve ter pelo menos 3 caracteres.',
            'name.max' => 'O nome não pode ter mais de 150 caracteres.',

            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.max' => 'O e-mail não pode ter mais de 255 caracteres.',

            'phone.required' => 'O telefone é obrigatório.',
            'phone.min' => 'O telefone é demasiado curto.',
            'phone.max' => 'O telefone é demasiado longo.',
            'phone.regex' => 'O telefone possui um formato inválido.',

            'software.required' => 'O software é obrigatório.',
            'software.min' => 'O nome do software deve ter pelo menos 2 caracteres.',
            'software.max' => 'O nome do software não pode ter mais de 150 caracteres.',

            'demo_date.required' => 'A data da demonstração é obrigatória.',
            'demo_date.date_format' => 'A data deve estar no formato AAAA-MM-DD.',
            'demo_date.after_or_equal' => 'A data da demonstração não pode estar no passado.',

            'demo_time.required' => 'A hora da demonstração é obrigatória.',
            'demo_time.date_format' => 'A hora deve estar no formato HH:MM.',

            'message.string' => 'A mensagem deve ser um texto.',
            'message.max' => 'A mensagem não pode ter mais de 2000 caracteres.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nome',
            'email' => 'e-mail',
            'phone' => 'telefone',
            'company' => 'empresa',
            'software' => 'software',
            'demo_date' => 'data da demonstração',
            'demo_time' => 'hora da demonstração',
            'timezone' => 'fuso horário',
            'message' => 'mensagem',
        ];
    }
}
