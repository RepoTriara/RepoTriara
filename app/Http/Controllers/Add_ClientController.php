<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;

class Add_ClientController extends Controller
{
    public function create()
    {
        return view('add_client', compact('groups'));
        
    }
    public function index()
    {
        // Obtener todos los usuarios (puedes agregar filtros o paginación si es necesario)
        $users = User::all();  // O puedes usar paginate() para paginación

        return view('customers_manage', compact('users'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'user' => ['required', 'string', 'max:60', 'unique:tbl_users'], 
            'password' => ['required', 'string', 'min:8'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:32'],
            'contact' => ['nullable', 'string', 'max:255'],
            'max_file_size' => ['nullable', 'integer', 'min:0'],
            /*'group_request' => ['nullable', 'array'],*/
            'active' => ['nullable', 'boolean'],
            'notify' => ['nullable', 'boolean'],
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'user' => $request->user,
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'address' => $request->address,
                'phone' => $request->phone,
                'contact' => $request->contact,
                'max_file_size' => $request->max_file_size,
                'level' => 0,
                'active' => $request->active,
                'notify' => $request->notify,
                /*'group_request' => $request->group_request,*/
            ]);
            session()->flash('success', 'cliente registrado correctamente');
        } catch (\Exception $e) {
            session()->flash('error', 'Hubo un problema al registrar el clientye. Inténtalo nuevamente.');
        }
        return back();
    }
}
