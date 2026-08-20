<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Place extends Model
{
    use HasFactory;

    /**
     * Camps que es poden assignar massivament.
     *
     * trip_id no forma part de fillable perquè els llocs es creen
     * mitjançant la relació places() del viatge.
     *
     * @var list<string>
     */
    protected $fillable = [
        'category_id',
        'name',
        'country',
        'description',
        'latitude',
        'longitude',
        'visited',
    ];

    /**
     * Conversions automàtiques dels atributs.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'visited' => 'boolean',
        ];
    }

    /**
     * Viatge al qual pertany el lloc.
     */
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    /**
     * Categoria assignada al lloc.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Limita la consulta als llocs visitats.
     */
    public function scopeVisited(Builder $query): Builder
    {
        return $query->where('visited', true);
    }

    /**
     * Limita la consulta als llocs pendents.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('visited', false);
    }

    /**
     * Limita la consulta als llocs que tenen coordenades completes.
     */
    public function scopeWithCoordinates(Builder $query): Builder
    {
        return $query
            ->whereNotNull('latitude')
            ->whereNotNull('longitude');
    }
}
