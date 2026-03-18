<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'amount' => ['required', 'numeric', 'min:1']
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => 'Įveskite sumą',
            'amount.numeric' => 'Suma turi būti skaičius',
            'amount.min' => 'Minimali suma yra 1€'
        ];
    }
}
