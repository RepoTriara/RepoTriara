<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TblCategory;
use App\Models\TblCategoryRelation;
use App\Models\TblFile;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    // Mostrar todas las categorías con la cantidad de archivos asociados
    public function index(Request $request)
    {
        // Iniciamos la consulta
        $query = TblCategory::query();

        // Verificamos si hay un término de búsqueda
        if ($request->has('search') && !empty($request->search)) {
            // Filtramos por nombre o descripción de la categoría
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Agregamos el conteo de archivos relacionados
        $query->withCount(['categoryRelations as files_count' => function ($q) {
            $q->selectRaw('count(distinct file_id)');
        }]);

        // Usamos paginación en lugar de `all()`
        $categories = $query->paginate(10); // 10 categorías por página
        $totalCategories = $categories->total(); // Total de categorías

        return view('category.categories', compact('categories', 'totalCategories'));
    }

    // Mostrar un formulario para crear una nueva categoría
    public function create()
    {
        $categories = TblCategory::all();  // Para mostrar las categorías disponibles para seleccionar como padre
        return view('category.create', compact('categories'));
    }

    // Guardar una nueva categoría
    public function store(Request $request)
    {
        // Validación de los campos
        $request->validate([
            'name' => 'required',
            'parent' => 'nullable|exists:tbl_categories,id',  // Validar que el padre exista
            'description' => 'nullable',
        ]);

        // Crear la categoría, incluyendo el campo created_by con el nombre del usuario
        TblCategory::create([
            'name' => $request->name,
            'parent' => $request->parent,
            'description' => $request->description,
            'created_by' => Auth::user()->user, // Aquí asignas el nombre de usuario
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('categories.index')->with('success', 'Categoría creada correctamente.');
    }

    // Mostrar detalles de una categoría (incluyendo el padre y los hijos)
    public function show($id)
    {
        $category = TblCategory::with(['parentCategory', 'childCategories'])->findOrFail($id);
        return view('categories.show', compact('category'));
    }

    // Editar una categoría existente
    public function edit($id)
    {
        // Encontrar la categoría por su ID
        $category = TblCategory::findOrFail($id); // Este método debe devolver la categoría para que puedas editarla

        // Pasar la categoría a la vista
        $categories = TblCategory::all();  // Para mostrar las categorías disponibles para seleccionar como padre

        return view('category.edit', compact('category', 'categories')); // Aquí 'category' contiene los datos de la categoría a editar
    }

    // Actualizar una categoría
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'parent' => 'nullable|exists:tbl_categories,id',
            'description' => 'nullable',
        ]);

        $category = TblCategory::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Categoría actualizada correctamente.');
    }

    // Eliminar una categoría individual
    public function destroy($id)
    {
        $category = TblCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Categoría eliminada correctamente.');
    }

    // Eliminar categorías seleccionadas (eliminación masiva)
    public function bulkDelete(Request $request)
    {
        $categoryIds = $request->input('categories');

        // Verificar que se haya seleccionado al menos una categoría
        if ($categoryIds && is_array($categoryIds) && count($categoryIds) > 0) {
            TblCategory::whereIn('id', $categoryIds)->delete();
            return redirect()->route('categories.index')->with('success', 'Categorías eliminadas correctamente.');
        }

        return redirect()->route('categories.index')->with('error', 'No se seleccionaron categorías para eliminar.');
    }

    // Mostrar archivos relacionados a una categoría
    public function showFiles($id)
    {
        // Obtener la categoría
        $category = TblCategory::findOrFail($id);

        // Obtener los archivos relacionados mediante la tabla tbl_categories_relation
        $files = TblFile::whereHas('categoryRelations', function ($query) use ($id) {
            $query->where('cat_id', $id);
        })->get();

        return view('category.show_files', compact('files', 'category'));
    }
}
