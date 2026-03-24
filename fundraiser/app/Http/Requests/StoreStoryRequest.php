<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStoryRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'goal_amount' => 'required|numeric|min:1',

            'main_image' => 'required|image|mimes:jpg,jpeg,png,webp,avif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Įveskite pavadinimą.',
            'title.max' => 'Pavadinimas per ilgas.',

            'content.required' => 'Įveskite aprašymą.',

            'goal_amount.required' => 'Įveskite tikslinę sumą.',
            'goal_amount.numeric' => 'Suma turi būti skaičius.',
            'goal_amount.min' => 'Suma turi būti didesnė nei 0.',

            'main_image.required' => 'Pasirinkite pagrindinę nuotrauką.',
            'main_image.image' => 'Failas turi būti nuotrauka.',
            'main_image.mimes' => 'Leidžiami formatai: jpg, jpeg, png, webp, avif.',
            'main_image.max' => 'Nuotrauka per didelė (max 2MB).',
        ];
    }
}
