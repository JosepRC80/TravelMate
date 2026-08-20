<?php

namespace App\Policies;

use App\Models\Note;
use App\Models\User;

class NotePolicy
{
    /**
     * Determina si l'usuari pot eliminar la nota.
     */
    public function delete(User $user, Note $note): bool
    {
        return $note->trip->user_id === $user->id;
    }
}
