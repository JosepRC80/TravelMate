<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Mostra les categories de l'usuari autenticat.
     */
    public function index()
    {
        $categories = auth()->user()
            ->categories()
            ->orderBy('name')
            ->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Mostra el formulari de creació d'una categoria.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Guarda una categoria nova.
     */
    public function store(StoreCategoryRequest $request)
    {
        $request->user()
            ->categories()
            ->create($request->validated());

        return redirect()
            ->route('categories.index')
            ->with('message', 'Categoria creada correctament.');
    }

    /**
     * Mostra el formulari d'edició d'una categoria.
     */
    public function edit(Category $category)
    {
        Gate::authorize('update', $category);

        return view('categories.edit', compact('category'));
    }

    /**
     * Actualitza una categoria existent.
     */
    public function update(
        UpdateCategoryRequest $request,
        Category $category
    ) {
        $category->update($request->validated());

        return redirect()
            ->route('categories.index')
            ->with('message', 'Categoria modificada correctament.');
    }

    /**
     * Elimina una categoria.
     */
    public function destroy(Category $category)
    {
        Gate::authorize('delete', $category);

        if ($category->places()->exists()) {
            return redirect()
                ->route('categories.index')
                ->with(
                    'message',
                    'No pots eliminar una categoria que té llocs associats.'
                );
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('message', 'Categoria eliminada correctament.');
    }
}
