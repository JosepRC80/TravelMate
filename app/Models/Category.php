<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    /**
     * Camps que es poden assignar massivament.
     *
     * user_id no forma part de fillable perquè la categoria es crea
     * sempre mitjançant la relació categories() de l'usuari.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Usuari propietari de la categoria.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Llocs que utilitzen aquesta categoria.
     */
    public function places(): HasMany
    {
        return $this->hasMany(Place::class);
    }
}
