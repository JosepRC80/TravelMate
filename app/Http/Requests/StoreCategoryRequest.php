<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determina si l'usuari pot crear una categoria.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Regles de validació per crear una categoria.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('categories', 'name')
                    ->where('user_id', $this->user()->id),
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
