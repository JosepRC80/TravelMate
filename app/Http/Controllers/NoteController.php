<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Models\Note;
use App\Models\Trip;
use Illuminate\Support\Facades\Gate;

class NoteController extends Controller
{
    /**
     * Mostra el formulari de creació d'una nota.
     */
    public function create(Trip $trip)
    {
        Gate::authorize('addNote', $trip);

        return view('notes.create', compact('trip'));
    }

    /**
     * Guarda una nota nova dins del viatge.
     */
    public function store(StoreNoteRequest $request, Trip $trip)
    {
        $trip->notes()->create($request->validated());

        return redirect()
            ->route('trips.show', $trip)
            ->with('message', 'Nota creada correctament.');
    }

    /**
     * Elimina una nota del viatge.
     */
    public function destroy(Trip $trip, Note $note)
    {
        Gate::authorize('delete', $note);

        $note->delete();

        return redirect()
            ->route('trips.show', $trip)
            ->with('message', 'Nota eliminada correctament.');
    }
}
