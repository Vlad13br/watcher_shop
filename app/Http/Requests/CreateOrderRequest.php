<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'payment_method' => 'required|string|max:50',
            'place' => 'required|string|max:50',
        ];
    }
    public function messages(): array
    {
        return [
            'payment_method.required' => 'Будь ласка, оберіть спосіб оплати.',
            'payment_method.string' => 'Спосіб оплати повинен бути рядком.',
            'payment_method.max' => 'Спосіб оплати занадто довгий.',
            'place.required' => 'Будь ласка, вкажіть місце доставки.',
            'place.string' => 'Місце доставки повинно бути рядком.',
            'place.max' => 'Місце доставки занадто довге.',
        ];
    }
}
