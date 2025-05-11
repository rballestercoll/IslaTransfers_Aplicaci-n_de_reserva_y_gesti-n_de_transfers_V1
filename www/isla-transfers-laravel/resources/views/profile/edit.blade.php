@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')
<div class="container mt-5" style="max-width: 600px; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.2);">
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf

        <div class="text-center mb-4">
            <img src="{{ asset('images/profile-edit.jpg') }}" alt="Editar perfil" style="width: 80px; height: auto;">
            <h3 class="mt-3">Editar perfil</h3>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $user->nombre ?? $user->nombre_hotel) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? $user->email_admin ?? $user->email_hotel) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nueva contraseña <span class="text-muted">(opcional)</span></label>
            <input type="password" name="password" class="form-control" placeholder="Dejar en blanco si no deseas cambiarla">
        </div>

        <div class="mb-3">
            <label class="form-label">Confirmar nueva contraseña</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
    </form>
</div>
@endsection
