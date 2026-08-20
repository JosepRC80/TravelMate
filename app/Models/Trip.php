<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trip extends Model
{
    use HasFactory;

    /**
     * Camps que es poden assignar massivament.
     *
     * user_id no forma part de fillable perquè el viatge es crea
     * sempre mitjançant la relació trips() de l'usuari autenticat.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'country',
        'description',
        'start_date',
        'end_date',
    ];

    /**
     * Conversions automàtiques dels atributs.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    /**
     * Usuari propietari del viatge.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Llocs associats al viatge.
     */
    public function places(): HasMany
    {
        return $this->hasMany(Place::class);
    }

    /**
     * Notes associades al viatge.
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}
