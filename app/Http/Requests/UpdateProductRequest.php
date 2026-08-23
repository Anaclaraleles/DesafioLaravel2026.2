<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
         return [
            'name' => ['required', 'string', 'min:3', 'max:150'],
            'description' => ['required', 'string'],
            'category' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'quantity' => ['required', 'integer', 'min:0'],
            'photo' => ['nullable','image', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome do produto é obrigatório.',
            'name.string' => 'O nome do produto deve ser um texto.',
            'name.min' => 'O nome do produto deve ter no mínimo 3 caracteres.',
            'name.max' => 'O nome do produto deve ter no máximo 150 caracteres.',

            'description.required' => 'A descrição do produto é obrigatória.',
            'description.string' => 'A descrição do produto deve ser um texto.',

            'category.required' => 'A categoria do produto é obrigatória.',
            'category.string' => 'A categoria deve ser um texto.',
            'category.max' => 'A categoria deve ter no máximo 100 caracteres.',

            'price.required' => 'O preço do produto é obrigatório.',
            'price.numeric' => 'O preço deve ser um número.',
            'price.min' => 'O preço não pode ser negativo.',

            'quantity.required' => 'A quantidade do produto é obrigatória.',
            'quantity.integer' => 'A quantidade deve ser um número inteiro.',
            'quantity.min' => 'A quantidade não pode ser negativa.',

            'photo.image' => 'O arquivo enviado deve ser uma imagem.',
            'photo.max' => 'A foto deve ter no máximo 2 MB.',
        ];
    }
}
