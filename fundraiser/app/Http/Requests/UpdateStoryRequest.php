<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStoryRequest extends FormRequest
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
            'main_image' => 'nullable|image|max:2048',
            'gallery_images.*' => 'nullable|image|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Įveskite pavadinimą',
            'content.required' => 'Įveskite aprašymą',
            'goal_amount.required' => 'Įveskite tikslinę sumą',
            'goal_amount.numeric' => 'Suma turi būti skaičius',
            'goal_amount.min' => 'Suma turi būti bent 1€',
            'main_image.image' => 'Failas turi būti nuotrauka',
        ];
    }
}
