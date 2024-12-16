<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Members;

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
        \Log::info('Solicitud recibida', $request->all());
    
        // Convertir el checkbox a un booleano
        $request->merge([
            'add_group_form_public' => $request->has('add_group_form_public')
        ]);
    
        // Validar los datos del formulario
        $request->validate([
            'add_group_form_name' => 'required|string|max:255',
            'add_group_form_description' => 'nullable|string',
            'add_group_form_public' => 'nullable|boolean',
            'add_group_form_members' => 'nullable|array',
        ]);
    
        $userId = auth()->id();
    
        // Crear el grupo
        $group = new \App\Models\Groups();
        $group->created_by = $userId;
        $group->name = $request->input('add_group_form_name');
        $group->description = $request->input('add_group_form_description');
        $group->public = $request->input('add_group_form_public');
    
        \Log::info('Datos del grupo antes de guardar', $group->toArray());
    
        $group->save();
    
        \Log::info('Grupo guardado exitosamente con ID: ' . $group->id);
    
        // Asociar miembros al grupo si existen
        if ($request->has('add_group_form_members')) {
            foreach ($request->input('add_group_form_members') as $memberId) {
                Members::create([
                    'group_id' => $group->id,
                    'client_id' => $memberId,
                    'added_by' => auth()->user()->name,
                ]);
            }
            \Log::info('Miembros asociados al grupo exitosamente');
        }
    
        return redirect()->route('add_company')->with('success', 'Grupo creado exitosamente.');
    }
    


    



}

