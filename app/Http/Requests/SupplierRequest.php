<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
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
        $supplier = $this->route('supplier');

        $rules = [
            'name' => ['required','string','min:3','max:80', Rule::unique('suppliers','name')->ignore($supplier) ],

            'phone' => ['required','string','regex:/^0[5-7][0-9]{8}$/', Rule::unique('suppliers','phone')->ignore($supplier) ],

            'address' => 'nullable|string|max:255',

            'note' => 'nullable|string|max:500',

            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:10000',
        ];

        return $rules;
    }
}
