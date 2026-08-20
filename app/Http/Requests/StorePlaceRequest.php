<?php

namespace App\Http\Requests;

use App\Models\Trip;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePlaceRequest extends FormRequest
{
    /**
     * Determina si l'usuari pot afegir un lloc al viatge.
     */
    public function authorize(): bool
    {
        $trip = $this->route('trip');

        return $trip instanceof Trip
            && $this->user()?->can('addPlace', $trip);
    }

    /**
     * Regles de validació per crear un lloc.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:150',
            ],
            'country' => [
                'required',
                'string',
                'min:2',
                'max:100',
            ],
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')
                    ->where('user_id', $this->user()->id),
            ],
            'description' => [
                'nullable',
                'string',
                'max:2000',
            ],
            'latitude' => [
                'nullable',
                'numeric',
                'between:-90,90',
            ],
            'longitude' => [
                'nullable',
                'numeric',
                'between:-180,180',
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
            'name.required' => 'El nom del lloc és obligatori.',
            'name.min' => 'El nom del lloc ha de contenir almenys 3 caràcters.',
            'name.max' => 'El nom del lloc no pot superar els 150 caràcters.',

            'country.required' => "Has d'indicar un país.",
            'country.min' => 'El país ha de contenir almenys 2 caràcters.',
            'country.max' => 'El país no pot superar els 100 caràcters.',

            'category_id.required' => 'Has de seleccionar una categoria.',
            'category_id.integer' => 'La categoria seleccionada no és vàlida.',
            'category_id.exists' =>
            'La categoria seleccionada no existeix o no et pertany.',

            'description.max' => 'La descripció no pot superar els 2.000 caràcters.',

            'latitude.numeric' => 'La latitud ha de ser un valor numèric.',
            'latitude.between' => 'La latitud ha d’estar entre -90 i 90.',

            'longitude.numeric' => 'La longitud ha de ser un valor numèric.',
            'longitude.between' => 'La longitud ha d’estar entre -180 i 180.',
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
            'name' => 'nom del lloc',
            'country' => 'país',
            'category_id' => 'categoria',
            'description' => 'descripció',
            'latitude' => 'latitud',
            'longitude' => 'longitud',
        ];
    }
}
