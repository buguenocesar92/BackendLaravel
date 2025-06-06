<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class StoreProductRequest extends BaseFormRequest
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
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'description' => ['string'],
            'category_id' => ['required', 'exists:category,id'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre del producto es requerido.',
            'price.required' => 'El precio del producto es requerido.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
            'category_id.required' => 'La categoría del producto es requerida.',
        ];
    }

}
