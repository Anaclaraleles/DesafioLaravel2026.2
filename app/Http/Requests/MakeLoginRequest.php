<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MakeLoginRequest extends FormRequest
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
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }

    public function attempt(): bool
    {
        if ($user = User::query()->where('email', '=', $this->email)->first()) {
            if (Hash::check($this->password, $user->password)) {
                auth()->login($user);

                return true;
            }
        }

        return false;
    }
}
