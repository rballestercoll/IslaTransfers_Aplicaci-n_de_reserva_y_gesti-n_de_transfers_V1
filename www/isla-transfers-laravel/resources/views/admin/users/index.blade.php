@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Usuarios</h1>
        <a href="{{ route('admin.users.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Nuevo usuario
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white border">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 border-b text-left">Nombre</th>
                <th class="px-4 py-2 border-b text-left">Email</th>
                <th class="px-4 py-2 border-b text-left">Roles</th>
                <th class="px-4 py-2 border-b text-left">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td class="px-4 py-2 border-b">{{ $user->name }}</td>
                <td class="px-4 py-2 border-b">{{ $user->email }}</td>
                <td class="px-4 py-2 border-b">
                    {{ $user->getRoleNames()->implode(', ') ?: '—' }}
                </td>
                <td class="px-4 py-2 border-b space-x-2">
                    <a href="{{ route('admin.users.edit', $user) }}"
                       class="text-blue-600 hover:underline">Editar</a>

                    <form action="{{ route('admin.users.destroy', $user) }}"
                          method="POST" class="inline"
                          onsubmit="return confirm('¿Eliminar este usuario?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="text-red-600 hover:underline">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
