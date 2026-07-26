<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $user = $this->route('user');
        $rules = [
            'name' => [
                'required',
                'string',
                'between:4,20',
                Rule::unique('users','name')->ignore($user),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'between:7,50',
                Rule::unique('users','email')->ignore($user) 
            ],
            'phone' => [
                'required',
                'string',
                'regex:/^0[5-7][0-9]{8}$/',
                Rule::unique('users','phone')->ignore($user) 
            ],
            
        ];
        if ($this->isMethod('POST')) {
            $rules['password'] = 'required|string|confirmed|min:8|max:50';
        }

        return $rules;
    }
}
