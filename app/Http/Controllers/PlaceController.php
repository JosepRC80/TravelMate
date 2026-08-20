<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlaceRequest;
use App\Http\Requests\UpdatePlaceRequest;
use App\Models\Category;
use App\Models\Place;
use App\Models\Trip;
use Illuminate\Support\Facades\Gate;

class PlaceController extends Controller
{
    /**
     * Mostra el formulari de creació d'un lloc.
     */
    public function create(Trip $trip)
    {
        Gate::authorize('addPlace', $trip);

        $categories = Category::where('user_id', auth()->id())
            ->orderBy('name')
            ->get();

        return view('places.create', compact('trip', 'categories'));
    }

    /**
     * Guarda un lloc nou dins del viatge.
     */
    public function store(StorePlaceRequest $request, Trip $trip)
    {
        $trip->places()->create($request->validated());

        return redirect()
            ->route('trips.show', $trip)
            ->with('message', 'Lloc creat correctament.');
    }

    /**
     * Mostra el formulari d'edició d'un lloc.
     */
    public function edit(Trip $trip, Place $place)
    {
        Gate::authorize('update', $place);

        $categories = Category::where('user_id', auth()->id())
            ->orderBy('name')
            ->get();

        return view('places.edit', compact('trip', 'place', 'categories'));
    }

    /**
     * Actualitza un lloc existent.
     */
    public function update(
        UpdatePlaceRequest $request,
        Trip $trip,
        Place $place
    ) {
        $place->update($request->validated());

        return redirect()
            ->route('trips.show', $trip)
            ->with('message', 'Lloc modificat correctament.');
    }

    /**
     * Elimina un lloc del viatge.
     */
    public function destroy(Trip $trip, Place $place)
    {
        Gate::authorize('delete', $place);

        $place->delete();

        return redirect()
            ->route('trips.show', $trip)
            ->with('message', 'Lloc esborrat correctament.');
    }

    /**
     * Alterna l'estat visitat o pendent d'un lloc.
     */
    public function toggleVisited(Trip $trip, Place $place)
    {
        Gate::authorize('toggleVisited', $place);

        $place->update([
            'visited' => ! $place->visited,
        ]);

        return redirect()
            ->route('trips.show', $trip)
            ->with('message', 'Estat del lloc actualitzat correctament.');
    }
}
