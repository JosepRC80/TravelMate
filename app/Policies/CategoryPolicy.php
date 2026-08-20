<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    /**
     * Determina si l'usuari pot modificar la categoria.
     */
    public function update(User $user, Category $category): bool
    {
        return $category->user_id === $user->id;
    }

    /**
     * Determina si l'usuari pot eliminar la categoria.
     */
    public function delete(User $user, Category $category): bool
    {
        return $category->user_id === $user->id;
    }
}
