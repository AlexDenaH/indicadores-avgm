<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dependencia;
use App\Models\DependenciaArea;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /*
    | Listado de usuarios
    */
    public function index()
    {
        $users = User::with(['roles','dependencia','area'])->paginate(10);

        return view('users.index', compact('users'));
    }

    /*
    | Formulario crear
    */
    public function create()
    {
        $dependencias = Dependencia::where('activa',1)->get();
        $areas = DependenciaArea::where('activa',1)->get();
        $roles = Role::all();

        return view('users.create', compact('dependencias','areas','roles'));
    }

    /*
    | Guardar usuario
    */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'first_last_name' => 'required',
            'email' => 'required|email|unique:users',
            'email_verified_at' => 'required|email|same:email',
            'password' => 'required|confirmed|min:8',
            'id_dependencia' => 'required',
            'id_dep_area' => 'required',
            'role' => 'required'
        ], [
                // NAME
                'name.required' => 'El nombre es obligatorio.',
                // FIRST LAST NAME
                'first_last_name.required' => 'El apellido paterno es obligatorio.',
                // EMAIL
                'email.required' => 'El correo electrónico es obligatorio.',
                'email.email' => 'El correo electrónico debe ser una dirección válida.',
                'email.unique' => 'Este correo electrónico ya está registrado.',
                // EMAIL VERIFIED AT
                'email_verified_at.required' => 'El correo de verificación es obligatorio.',
                'email_verified_at.email' => 'El correo de verificación debe ser una dirección válida.',
                'email_verified_at.same' => 'El correo de verificación debe coincidir con el correo principal.',
                // PASSWORD
                'password.required' => 'La contraseña es obligatoria.',
                'password.confirmed' => 'La confirmación de la contraseña no coincide.',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
                // DEPENDENCIA
                'id_dependencia.required' => 'Debe seleccionar una dependencia.',
                // ÁREA
                'id_dep_area.required' => 'Debe seleccionar un área.',
                // ROL
                'role.required' => 'Debe seleccionar un rol.'
        ]);

        /*
        | Restricción de roles
        */
        if (
            auth()->user()->hasRole('administrador') &&
            !in_array($request->role,['enlace-dependencia','capturista'])
        ) {
            abort(403);
        }

        $user = User::create([
            'name' => $request->name,
            'first_last_name' => $request->first_last_name,
            'second_last_name' => $request->second_last_name,
            'email' => $request->email,
            'email_verified_at' => $request->email_verified_at,
            'password' => bcrypt($request->password),
            'id_dependencia' => $request->id_dependencia,
            'id_dep_area' => $request->id_dep_area,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')
            ->with('success','Usuario creado correctamente');
    }

    /*
    | Formulario editar
    */
    public function edit(User $user)
    {
        $dependencias = Dependencia::where('activa',1)->get();
        $areas = DependenciaArea::where('activa',1)->get();
        $roles = Role::all();

        return view('users.edit', compact('user','dependencias','areas','roles'));
    }

    /*
    | Actualizar usuario
    */
    public function update(Request $request, User $user)
    {

       // dd(array_keys($request->all()));
   $request->validate([
                    'name'              => 'required|string|max:255',
                    'first_last_name'   => 'nullable|string|max:255',
                    'second_last_name'  => 'nullable|string|max:255',
                    'email'             => 'required|email|unique:users,email,' . $user->id,
                    'id_dependencia'    => 'required|exists:dependencias,id',
                    'id_dep_area'       => 'required|exists:dependencia_areas,id',
                    'role'              => 'required'
                ]);

        if (
            auth()->user()->hasRole('administrador') &&
            !in_array($request->role,['enlace-dependencia','capturista'])
        ) {
            abort(403);
        }

            // Actualizar datos
    $user->update([
        'name'             => $request->name,
        'first_last_name'  => $request->first_last_name,
        'second_last_name' => $request->second_last_name,
        'email'            => $request->email,
        'email_verified_at'=> $request->email, 
        'id_dependencia'   => $request->id_dependencia,
        'id_dep_area'      => $request->id_dep_area,
    ]);
            
        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')
            ->with('success','Usuario actualizado');
    }

    /*
    | Eliminar (solo super-admin)
    */
    public function destroy(User $user)
    {
        abort_unless(auth()->user()->hasRole('super-admin'),403);

        $user->delete();

        return back()->with('success','Usuario eliminado');
    }

        /*
    | permissions
    */
            public function permissions(User $user)
        {
            $permissions = Permission::all();

            return view('users.permissions', compact('user','permissions'));
        }

        public function updatePermissions(Request $request, User $user)
            {
                $user->syncPermissions($request->permissions ?? []);

                return redirect()->route('users.index')
                    ->with('success','Permisos actualizados');
            }

            public function areasPorDependencia($dependenciaId)
            {
                return response()->json(
                    DependenciaArea::where('id_dependencia', $dependenciaId)
                        ->where('activa',1)
                        ->select('id','unidad_area')
                        ->orderBy('unidad_area')
                        ->get()
                );
            }        

}
