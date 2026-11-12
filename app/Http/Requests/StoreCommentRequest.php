<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
            'comment' => ['required', 'string', 'min:3', 'max:5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'comment.required' => 'Введите комментарий',
            'comment.string' => 'Комментарий должен быть текстом',
            'comment.min' => 'Комментарий должен содержать минимум 3 символа',
            'comment.max' => 'Комментарий не должен превышать 5000 символов',
        ];
    }
}
