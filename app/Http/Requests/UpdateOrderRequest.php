<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            'shipping_status' => 'required|string',
            'payment_method' => 'nullable|string|max:50',
        ];
    }
    public function messages(): array
    {
        return [
            'shipping_status.required' => 'Статус доставки обов’язковий.',
            'shipping_status.string' => 'Статус доставки повинен бути рядком.',
            'payment_method.string' => 'Спосіб оплати повинен бути рядком.',
            'payment_method.max' => 'Спосіб оплати занадто довгий.',
        ];
    }
}
