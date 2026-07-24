<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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

    public function attributes() : array
    {
        return [
            'title' => 'titre',
            'category_id' => 'catégorie',
            'images' => 'images',
            'description' => 'description',
            'purchase_price' => "prix d'achat",
            'selling_price' => 'prix de vente',
            'stock' => 'stock',
            'is_active' => 'statut',
        ];
    }
    
    public function messages(): array
    {
        return [
            'images.required' => 'Veuillez ajouter au moins une image.',
            'images.max' => 'Vous ne pouvez pas ajouter plus de 10 images.',
        ];
    }
    public function rules(): array
    {
        $product = $this->route('product');
        return [
            'title' => [
                'required',
                'string',
                'min:5',
                'max:70',
                Rule::unique('products','title')->ignore($product) // Check if titles exist and skip this current product edited
            ],

            'description' => 'nullable|string|max:1000',

            'stock' => 'required|integer|min:0|max:9999',

            'category_id' => 'nullable|exists:categories,id',

            'images' => 'required|array|max:10',

            'images.*' => 'image|mimes:png,jpg,jpeg|max:10000',

            'primary_image' => 'required|integer',

            'purchase_price' => 'required|numeric|min:1|max:9999',

            'selling_price' => 'required|numeric|min:1|max:9999|gte:purchase_price',

            'is_active' => 'required|boolean',
        ];
    }
}
