<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
        return [
            'title' => ['required', 'max:255', 'min:3'],
            'content' => ['nullable', 'min:3', 'max:65000'],
            'category_id' => ['required', 'exists:categories,id'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:3048'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Заголовок обязателен',
            'title.max' => 'Заголовок не должен превышать 255 символов',
            'title.min' => 'Заголовок должен содержать минимум 3 символа',
            'content.required' => 'Содержание обязательно',
            'content.min' => 'Содержание должен быть минимум 3 символа',
            'category_id.required' => 'Выберите категорию',
            'category_id.exists' => 'Выбранная категория не существует',
        ];
    }
}
