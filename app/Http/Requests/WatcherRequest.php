<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WatcherRequest extends FormRequest
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
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'material' => 'nullable|string|max:50',
            'brand' => 'nullable|string|max:50',
            'stock' => 'required|integer|min:0',
            'image_url' => 'nullable|url',
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => 'Назва продукту обов’язкова.',
            'price.required' => 'Ціна обов’язкова.',
            'price.numeric' => 'Ціна має бути числом.',
            'stock.integer' => 'Кількість має бути цілим числом.',
            'image_url.url' => 'URL зображення некоректний.',
        ];
    }
}
