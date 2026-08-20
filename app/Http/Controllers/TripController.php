<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTripRequest;
use App\Http\Requests\UpdateTripRequest;
use App\Models\Trip;
use Illuminate\Support\Facades\Gate;

class TripController extends Controller
{
    /**
     * Mostra els viatges de l'usuari autenticat.
     */
    public function index()
    {
        $trips = auth()->user()->trips;

        return view('trips.index', compact('trips'));
    }

    /**
     * Mostra el formulari de creació d'un viatge.
     */
    public function create()
    {
        return view('trips.create');
    }

    /**
     * Guarda un viatge nou.
     */
    public function store(StoreTripRequest $request)
    {
        $request->user()
            ->trips()
            ->create($request->validated());

        return redirect()
            ->route('trips.index')
            ->with('message', 'Viatge guardat correctament.');
    }

    /**
     * Mostra un viatge concret.
     */
    public function show(Trip $trip)
    {
        Gate::authorize('view', $trip);

        $trip->load('places.category', 'notes');

        return view('trips.show', compact('trip'));
    }

    /**
     * Mostra el formulari d'edició del viatge.
     */
    public function edit(Trip $trip)
    {
        Gate::authorize('update', $trip);

        return view('trips.edit', compact('trip'));
    }

    /**
     * Actualitza un viatge existent.
     */
    public function update(UpdateTripRequest $request, Trip $trip)
    {
        $trip->update($request->validated());

        return redirect()
            ->route('trips.index')
            ->with('message', 'Viatge modificat correctament.');
    }

    /**
     * Elimina un viatge.
     */
    public function destroy(Trip $trip)
    {
        Gate::authorize('delete', $trip);

        $trip->delete();

        return redirect()
            ->route('trips.index')
            ->with('message', 'Viatge eliminat correctament.');
    }
}
