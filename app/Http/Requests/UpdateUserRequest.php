<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'email' => [
                'required', 'string', 'email', 'max:150',
                Rule::unique(User::class)->ignore($this->route('user')->id),
            ],
            'cpf' => [
                'required', 'string', 'size:11',
                Rule::unique(User::class)->ignore($this->route('user')->id),
            ],
            'phone' => ['required', 'string', 'max:20'],
            'birth_date' => ['required', 'date', 'before:today'],
            'balance' => ['nullable', 'numeric', 'min:0'],
            'photo' => ['nullable', 'image', 'max:2048'],

            'cep' => ['required', 'string', 'size:8'],
            'street' => ['required', 'string', 'max:150'],
            'number' => ['required', 'string', 'max:10'],
            'neighborhood' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'size:2'],
            'complement' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [

            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser um texto.',
            'name.min' => 'O nome deve ter no mínimo 3 caracteres.',
            'name.max' => 'O nome deve ter no máximo 150 caracteres.',

            'email.required' => 'O e-mail é obrigatório.',
            'email.string' => 'O e-mail deve ser um texto.',
            'email.email' => 'Digite um e-mail válido.',
            'email.max' => 'O e-mail deve ter no máximo 150 caracteres.',
            'email.unique' => 'Este e-mail já está em uso.',

            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.string' => 'O CPF deve ser um texto.',
            'cpf.size' => 'O CPF deve ter exatamente 11 caracteres.',
            'cpf.unique' => 'Este CPF já está em uso.',

            'phone.required' => 'O telefone é obrigatório.',
            'phone.string' => 'O telefone deve ser um texto.',
            'phone.max' => 'O telefone deve ter no máximo 20 caracteres.',

            'birth_date.required' => 'A data de nascimento é obrigatória.',
            'birth_date.date' => 'A data de nascimento deve ser uma data válida.',
            'birth_date.before' => 'A data de nascimento deve ser anterior à data de hoje.',

            'balance.numeric' => 'O saldo deve ser um número.',
            'balance.min' => 'O saldo não pode ser negativo.',

            'photo.image' => 'O arquivo enviado deve ser uma imagem.',
            'photo.max' => 'A foto deve ter no máximo 2 MB.',

            'cep.required' => 'O CEP é obrigatório.',
            'cep.string' => 'O CEP deve ser um texto.',
            'cep.size' => 'O CEP deve ter exatamente 8 caracteres.',

            'street.required' => 'A rua é obrigatória.',
            'street.string' => 'A rua deve ser um texto.',
            'street.max' => 'A rua deve ter no máximo 150 caracteres.',

            'number.required' => 'O número é obrigatório.',
            'number.string' => 'O número deve ser um texto.',
            'number.max' => 'O número deve ter no máximo 10 caracteres.',

            'neighborhood.required' => 'O bairro é obrigatório.',
            'neighborhood.string' => 'O bairro deve ser um texto.',
            'neighborhood.max' => 'O bairro deve ter no máximo 100 caracteres.',

            'city.required' => 'A cidade é obrigatória.',
            'city.string' => 'A cidade deve ser um texto.',
            'city.max' => 'A cidade deve ter no máximo 100 caracteres.',

            'state.required' => 'O estado é obrigatório.',
            'state.string' => 'O estado deve ser um texto.',
            'state.size' => 'O estado deve ter exatamente 2 caracteres.',

            'complement.max' => 'O complemento deve ter no máximo 100 caracteres.',
        ];
    }
}
