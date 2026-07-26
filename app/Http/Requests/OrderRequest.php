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
        $isCreate = $this->isMethod('POST');
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
            'district_id' => 'required|integer',
            'address' => 'required|string|min:3|max:150',
        ];
        if($isCreate) $rules = array_merge($rules, [
            // Creation rules
        ]);
        return $rules;
    }
}
