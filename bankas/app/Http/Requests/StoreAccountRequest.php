<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccountRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => 'required|min:3',
            'surname' => 'required|min:3',
            'personal_code' => 'required|digits:11',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Įveskite vardą',
            'name.min' => 'Vardas turi būti bent 3 simboliai',

            'surname.required' => 'Įveskite pavardę',
            'surname.min' => 'Pavardė turi būti bent 3 simboliai',

            'personal_code.required' => 'Įveskite asmens kodą',
            'personal_code.digits' => 'Asmens kodas turi būti 11 skaičių',
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $code = $this->personal_code;

            // 1. LT AK validacija
            if (!$this->isValidLithuanianPersonalCode($code)) {
                $validator->errors()->add('personal_code', 'Neteisingas asmens kodas');
                return;
            }

            // 2. Unikalumo tikrinimas JSON faile
            $accounts = json_decode(
                file_get_contents(storage_path('app/accounts.json')),
                true
            );

            foreach ($accounts as $acc) {
                if ($acc['personal_code'] === $code) {
                    $validator->errors()->add('personal_code', 'Toks asmens kodas jau egzistuoja');
                    break;
                }
            }
        });
    }
    private function isValidLithuanianPersonalCode($code)
    {
        // Tik 11 skaičių
        if (!preg_match('/^\d{11}$/', $code)) {
            return false;
        }

        $digits = array_map('intval', str_split($code));

        // Pradžia tik 3 arba 4
        if ($digits[0] !== 3 && $digits[0] !== 4) {
            return false;
        }

        // Metai pagal pirmą skaičių (1900–1999)
        $year = 1900 + ($digits[1] * 10 + $digits[2]);

        // Mėnuo ir diena
        $month = $digits[3] * 10 + $digits[4];
        $day   = $digits[5] * 10 + $digits[6];

        // Tikra data
        if (!checkdate($month, $day, $year)) {
            return false;
        }

        return true;
    }
}
