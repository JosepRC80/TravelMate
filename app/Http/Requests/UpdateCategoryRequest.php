<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determina si l'usuari pot modificar la categoria.
     */
    public function authorize(): bool
    {
        $category = $this->route('category');

        return $category instanceof Category
            && $this->user()?->can('update', $category);
    }

    /**
     * Regles de validació per actualitzar una categoria.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        /** @var Category $category */
        $category = $this->route('category');

        return [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categories', 'name')
                    ->where('user_id', $this->user()->id)
                    ->ignore($category->id),
            ],
        ];
    }

    /**
     * Missatges personalitzats de validació.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nom de la categoria és obligatori.',
            'name.max' => 'El nom de la categoria no pot superar els 100 caràcters.',
            'name.unique' => 'Ja tens una categoria amb aquest nom.',
        ];
    }

    /**
     * Noms entenedors dels camps.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nom de la categoria',
        ];
    }
}
