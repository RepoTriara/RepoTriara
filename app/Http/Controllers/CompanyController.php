<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Members;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CompanyController extends Controller
{
    // Método para mostrar el formulario de agregar compañía
    public function create()
    {
        // Obtener todos los integrantes de la tabla tbl_members con la información del cliente
        $members = Members::with('client')->get();
        
        // Retornar la vista con los integrantes
        return view('companies.add_company', compact('members'));
    }
   

    public function store(Request $request)
{
    Log::info('Solicitud recibida', $request->all());

    // Convertir el checkbox a un valor booleano
    $request->merge([
        'add_group_form_public' => $request->has('add_group_form_public')
    ]);

    // Verificar si el nombre ya existe en la base de datos
    $nombreExistente = DB::table('tbl_groups')->where('name', $request->input('add_group_form_name'))->exists();

    if ($nombreExistente) {
        Log::info('El nombre ya existe en la base de datos: ' . $request->input('add_group_form_name'));
        return redirect()->back()
            ->withErrors(['add_group_form_name' => '¡El nombre ya existe en la base de datos!'])
            ->withInput();
    }

    // Validar los datos del formulario
    $request->validate([
        'add_group_form_name' => 'required|string|max:255',
        'add_group_form_description' => 'nullable|string',
        'add_group_form_public' => 'nullable|boolean',
        'add_group_form_members' => 'nullable|array',
    ]);

    $userId = auth()->id();

    // Asignar un valor por defecto a la descripción si está vacía
    $description = $request->input('add_group_form_description');
    if (empty($description)) {
        $description = ''; // Valor predeterminado como cadena vacía
    }

    // Crear el grupo
    $group = new \App\Models\Groups();
    $group->created_by = $userId;
    $group->name = $request->input('add_group_form_name');
    $group->description = $description; // Asignar la descripción
    $group->public = $request->input('add_group_form_public', false);
    $group->public_token = substr(Str::uuid()->toString(), 0, 32);


    if ($group->public) {
        $group->public_token = substr(Str::uuid()->toString(), 0, 32); // Truncar a 32 caracteres
    }
    

    Log::info('Datos del grupo antes de guardar', $group->toArray());

    // Guardar el grupo en la base de datos
    $group->save();

    Log::info('Grupo guardado exitosamente con ID: ' . $group->id);

    // Asociar los miembros si existen
    if ($request->has('add_group_form_members')) {
        foreach ($request->input('add_group_form_members') as $memberId) {
            Members::create([
                'group_id' => $group->id,
                'client_id' => $memberId,
                'added_by' => auth()->user()->name,
            ]);
        }
        Log::info('Miembros asociados al grupo exitosamente');
    }

    return redirect()->route('add_company')->with('success', 'Grupo creado exitosamente.');
}

    

    


    



}

