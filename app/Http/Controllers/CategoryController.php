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
        $query->where('name', 'like', '%' . $request->search . '%')
            ->orWhere('description', 'like', '%' . $request->search . '%');
    }

    // Agregamos el conteo de archivos relacionados
    $query->withCount(['categoryRelations as files_count' => function ($q) {
        $q->selectRaw('count(distinct file_id)');
    }]);

    // Manejo del ordenamiento dinámico
    $orderBy = $request->get('orderby', 'name'); // Por defecto, ordena por nombre
    $order = $request->get('order', 'asc'); // Por defecto, en orden ascendente

    // Validar que el ordenamiento sea válido
    if (!in_array($orderBy, ['name', 'description'])) {
        $orderBy = 'name'; // Solo permitimos ordenar por nombre o descripción
    }
    if (!in_array($order, ['asc', 'desc'])) {
        $order = 'asc'; // Aseguramos que el orden sea válido
    }

    // Aplicamos la ordenación
    $query->orderBy($orderBy, $order);

    // Aplicamos paginación
    $categories = $query->paginate(10)->appends([
        'search' => $request->search,
        'orderby' => $orderBy,
        'order' => $order,
    ]);

    $totalCategories = $categories->total(); // Total de categorías

    return view('category.categories', compact('categories', 'totalCategories'));
}


    // Mostrar un formulario para crear una nueva categoría
    public function create()
    {
        $categories = TblCategory::all();  // Para mostrar las categorías disponibles para seleccionar como padre
        return view('category.create', compact('categories'));
    }

  public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:tbl_categories',
        'parent' => 'nullable|exists:tbl_categories,id',
        'description' => 'nullable',
    ]);

    TblCategory::create([
        'name' => $request->name,
        'parent' => $request->parent,
        'description' => $request->description,
        'created_by' => Auth::user()->user,
    ]);

    if ($request->ajax()) {
        return response()->json(['success' => 'Categoría creada correctamente.']);
    }

    return redirect()->route('categories.create')->with('success', 'Categoría creada correctamente.');
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
        'name' => 'required|unique:tbl_categories,name,' . $id,
        'parent' => 'nullable|exists:tbl_categories,id',
        'description' => 'nullable',
    ]);

    $category = TblCategory::findOrFail($id);
    $category->update($request->all());

    return redirect()->route('categories.edit', $id)->with('sweetalert', 'Categoría actualizada correctamente.');
}

    // Eliminar una categoría individual
    public function destroy($id)
    {
        $category = TblCategory::findOrFail($id);
        $category->delete();

    return response()->json(['success' => 'Categoría eliminada correctamente.']);
}

    // Eliminar categorías seleccionadas (eliminación masiva)
    public function bulkDelete(Request $request)
    {
        $categoryIds = $request->input('categories');

        // Verificar que se haya seleccionado al menos una categoría
        if ($categoryIds && is_array($categoryIds) && count($categoryIds) > 0) {
            TblCategory::whereIn('id', $categoryIds)->delete();
        return response()->json(['success' => 'Categorías eliminadas correctamente.']);        }

    return response()->json(['error' => 'No se seleccionaron categorías para eliminar.']);    }

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
