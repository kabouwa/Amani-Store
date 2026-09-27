<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|min:3|max:80',
            'phone' => [
                'required',
                'regex:/^0[5-7][0-9]{8}$/',
            ],
            'instagram' => [
                'nullable',
                'string',
                'regex:/^[a-zA-Z0-9._]{1,30}$/',
            ],
            'note' => 'nullable|max:255',

            'district_id' => 'required|integer',
            'address' => 'required|string|min:3|max:150',

            'items' => 'required|array|min:1',
            'items.*.slug' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1'
        ];

        return $rules;
    }
}
