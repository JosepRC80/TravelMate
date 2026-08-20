<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Note extends Model
{
    use HasFactory;

    /**
     * Camps que es poden assignar massivament.
     *
     * trip_id no forma part de fillable perquè les notes es creen
     * mitjançant la relació notes() del viatge.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'content',
    ];

    /**
     * Viatge al qual pertany la nota.
     */
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
}
