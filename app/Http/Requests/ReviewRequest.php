<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check(); // тільки залогінені
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'rating' => 'required|numeric|min:1|max:5',
            'review_text' => 'nullable|string|max:1000',
            'watcher_id' => 'required|exists:watchers,id',
        ];
    }

    public function messages(): array
    {
        return [
            'rating.required' => 'Оцінка обовʼязкова.',
            'rating.numeric' => 'Оцінка повинна бути числом.',
            'rating.min' => 'Мінімальна оцінка — 1.',
            'rating.max' => 'Максимальна оцінка — 5.',

            'review_text.string' => 'Текст відгуку має бути рядком.',
            'review_text.max' => 'Відгук не може перевищувати 1000 символів.',

            'watcher_id.required' => 'Товар не знайдено.',
            'watcher_id.exists' => 'Обраний товар не існує.',
        ];
    }
}
