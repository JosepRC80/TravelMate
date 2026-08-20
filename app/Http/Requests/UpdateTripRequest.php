<?php

namespace App\Http\Requests;

use App\Models\Trip;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTripRequest extends FormRequest
{
    /**
     * Determina si l'usuari pot modificar el viatge.
     */
    public function authorize(): bool
    {
        $trip = $this->route('trip');

        return $trip instanceof Trip
            && $this->user()?->can('update', $trip);
    }

    /**
     * Regles de validació per actualitzar un viatge.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:100',
            ],
            'country' => [
                'required',
                'string',
                'min:2',
                'max:100',
            ],
            'description' => [
                'nullable',
                'string',
                'max:550',
            ],
            'start_date' => [
                'required',
                'date',
            ],
            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
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
            'title.required' => 'El nom del viatge és obligatori.',
            'title.max' => 'El nom del viatge no pot superar els 100 caràcters.',

            'country.required' => "Has d'indicar un país.",
            'country.min' => 'El país ha de contenir almenys 2 caràcters.',
            'country.max' => 'El país no pot superar els 100 caràcters.',

            'description.max' => 'La descripció no pot superar els 550 caràcters.',

            'start_date.required' => "Has d'indicar la data d'inici.",
            'start_date.date' => "La data d'inici no és vàlida.",

            'end_date.required' => "Has d'indicar la data final.",
            'end_date.date' => 'La data final no és vàlida.',
            'end_date.after_or_equal' =>
            "La data final ha de ser igual o posterior a la data d'inici.",
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
            'title' => 'nom del viatge',
            'country' => 'país',
            'description' => 'descripció',
            'start_date' => "data d'inici",
            'end_date' => 'data final',
        ];
    }
}
