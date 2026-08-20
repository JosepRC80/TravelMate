<?php

namespace App\Policies;

use App\Models\Trip;
use App\Models\User;

class TripPolicy
{
    /**
     * Determina si l'usuari pot veure el viatge.
     */
    public function view(User $user, Trip $trip): bool
    {
        return $trip->user_id === $user->id;
    }

    /**
     * Determina si l'usuari pot modificar el viatge.
     */
    public function update(User $user, Trip $trip): bool
    {
        return $trip->user_id === $user->id;
    }

    /**
     * Determina si l'usuari pot eliminar el viatge.
     */
    public function delete(User $user, Trip $trip): bool
    {
        return $trip->user_id === $user->id;
    }

    /**
     * Determina si l'usuari pot afegir llocs al viatge.
     */
    public function addPlace(User $user, Trip $trip): bool
    {
        return $trip->user_id === $user->id;
    }

    /**
     * Determina si l'usuari pot afegir notes al viatge.
     */
    public function addNote(User $user, Trip $trip): bool
    {
        return $trip->user_id === $user->id;
    }
}
