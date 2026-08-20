<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutes públiques
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Rutes privades
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Perfil
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Viatges
    |--------------------------------------------------------------------------
    |
    | Genera les rutes:
    |
    | trips.index
    | trips.create
    | trips.store
    | trips.show
    | trips.edit
    | trips.update
    | trips.destroy
    |
    */

    Route::resource('trips', TripController::class);

    /*
    |--------------------------------------------------------------------------
    | Recursos vinculats als viatges
    |--------------------------------------------------------------------------
    |
    | scopeBindings() garanteix que els llocs i les notes es resolguin
    | mitjançant les relacions places() i notes() del viatge de la URL.
    |
    */

    Route::scopeBindings()->group(function () {
        /*
        |--------------------------------------------------------------------------
        | Llocs
        |--------------------------------------------------------------------------
        |
        | No existeixen les pantalles places.index ni places.show perquè
        | els llocs es mostren dins de la vista del viatge.
        |
        */

        Route::resource('trips.places', PlaceController::class)
            ->except(['index', 'show'])
            ->names([
                'create' => 'places.create',
                'store' => 'places.store',
                'edit' => 'places.edit',
                'update' => 'places.update',
                'destroy' => 'places.destroy',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Estat visitat del lloc
        |--------------------------------------------------------------------------
        |
        | Aquesta és una acció específica del domini i no forma part
        | de les set accions CRUD estàndard d'un resource controller.
        |
        */

        Route::patch(
            '/trips/{trip}/places/{place}/visited',
            [PlaceController::class, 'toggleVisited']
        )->name('places.toggleVisited');

        /*
        |--------------------------------------------------------------------------
        | Notes
        |--------------------------------------------------------------------------
        |
        | Les notes només es poden crear i eliminar per decisió de disseny.
        | No tenen index, show, edit ni update independents.
        |
        */

        Route::resource('trips.notes', NoteController::class)
            ->only(['create', 'store', 'destroy'])
            ->names([
                'create' => 'notes.create',
                'store' => 'notes.store',
                'destroy' => 'notes.destroy',
            ]);
    });

    /*
    |--------------------------------------------------------------------------
    | Categories
    |--------------------------------------------------------------------------
    |
    | No existeix una pantalla individual categories.show.
    |
    */

    Route::resource('categories', CategoryController::class)
        ->except(['show']);
});

require __DIR__ . '/auth.php';
