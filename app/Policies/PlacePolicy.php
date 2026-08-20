<?php

namespace App\Policies;

use App\Models\Place;
use App\Models\User;

class PlacePolicy
{
    /**
     * Determina si l'usuari pot modificar el lloc.
     */
    public function update(User $user, Place $place): bool
    {
        return $place->trip->user_id === $user->id;
    }

    /**
     * Determina si l'usuari pot eliminar el lloc.
     */
    public function delete(User $user, Place $place): bool
    {
        return $place->trip->user_id === $user->id;
    }

    /**
     * Determina si l'usuari pot canviar l'estat visitat del lloc.
     */
    public function toggleVisited(User $user, Place $place): bool
    {
        return $place->trip->user_id === $user->id;
    }
}
