<?php

namespace App\Http\Requests;

use App\Models\Trip;
use Illuminate\Foundation\Http\FormRequest;

class StoreNoteRequest extends FormRequest
{
    /**
     * Determina si l'usuari pot afegir una nota al viatge.
     */
    public function authorize(): bool
    {
        $trip = $this->route('trip');

        return $trip instanceof Trip
            && $this->user()?->can('addNote', $trip);
    }

    /**
     * Regles de validació per crear una nota.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'min:3',
                'max:150',
            ],
            'content' => [
                'required',
                'string',
                'max:5000',
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
            'title.required' => 'El títol de la nota és obligatori.',
            'title.min' => 'El títol ha de contenir almenys 3 caràcters.',
            'title.max' => 'El títol no pot superar els 150 caràcters.',

            'content.required' => 'El contingut de la nota és obligatori.',
            'content.max' => 'La nota no pot superar els 5.000 caràcters.',
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
            'title' => 'títol',
            'content' => 'contingut',
        ];
    }
}
