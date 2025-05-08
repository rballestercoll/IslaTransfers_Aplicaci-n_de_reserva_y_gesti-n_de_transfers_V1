@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Crear usuario</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block font-medium">Nombre</label>
            <input type="text" id="name" name="name"
                   value="{{ old('name') }}"
                   class="w-full border rounded px-3 py-2"
                   required>
        </div>

        <div>
            <label for="email" class="block font-medium">Email</label>
            <input type="email" id="email" name="email"
                   value="{{ old('email') }}"
                   class="w-full border rounded px-3 py-2"
                   required>
        </div>

        <div>
            <label for="password" class="block font-medium">Contraseña</label>
            <input type="password" id="password" name="password"
                   class="w-full border rounded px-3 py-2"
                   required>
        </div>

        <div>
            <label for="password_confirmation" class="block font-medium">Confirmar contraseña</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   class="w-full border rounded px-3 py-2"
                   required>
        </div>

        <div>
            <label for="role" class="block font-medium">Rol</label>
            <select id="role" name="role" class="w-full border rounded px-3 py-2" required>
                <option value="" disabled selected>Selecciona un rol</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}"
                        {{ old('role') == $role->name ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <button type="submit"
                    class="bg-blue-600 text-white font-semibold px-4 py-2 rounded hover:bg-blue-700">
                Crear usuario
            </button>
            <a href="{{ route('admin.users.index') }}"
               class="ml-4 text-gray-600 hover:underline">
                Volver al listado
            </a>
        </div>
    </form>
</div>
@endsection
