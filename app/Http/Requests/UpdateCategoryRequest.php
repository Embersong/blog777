<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
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

        $category = $this->route('category');

        return [
            'name' => ['required', 'string', 'min:3', 'max:255', Rule::unique('categories', 'name')->ignore($category),],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Название категории обязательно',
            'name.min' => 'Название должно содержать минимум 3 символа',
            'name.max' => 'Название не должно превышать 255 символов',
            'name.unique' => 'Категория с таким названием уже существует',
            'description.max' => 'Описание не должно превышать 255 символов',
        ];
    }
}
