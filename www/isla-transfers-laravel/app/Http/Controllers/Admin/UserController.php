<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Si quieres, podrías protegerlo aquí también
    public function __construct()
    {
        $this->middleware(['auth','role:admin']);
    }

    /**
     * Mostrar listado de usuarios.
     */
    public function index()
    {
        // Paginamos de 10 en 10 (ajusta a tu gusto)
        $users = User::paginate(10);

        // Pasamos 'users' a la vista resources/views/admin/users/index.blade.php
        return view('admin.users.index', compact('users'));
    }

    /**
     * Mostrar formulario de creación de usuario.
     */
    public function create()
    {
        // Traemos todos los roles para poblar el <select>
        $roles = Role::all();

        // Pasamos 'roles' a resources/views/admin/users/create.blade.php
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Procesar creación de usuario.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|string|min:8|confirmed',
            'role'                  => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole($data['role']);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario creado correctamente');
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user','roles'));
    }

    /**
     * Procesar actualización.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role'  => 'required|exists:roles,name',
        ]);

        $user->update([
            'name'  => $data['name'],
            'email' => $data['email'],
        ]);

        $user->syncRoles([$data['role']]);

        return back()->with('success','Usuario actualizado correctamente');
    }

    /**
     * Eliminar usuario.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success','Usuario eliminado');
    }
}
