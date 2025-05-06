@extends('layouts.app')

@section('title','Mi Perfil')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <h2>Mi Perfil</h2>
    <form method="POST" action="{{ route('perfil.update') }}">
      @csrf @method('PATCH')

      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}"
               class="form-control @error('email') is-invalid @enderror" required>
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label>Nombre</label>
        <input type="text" name="nombre" value="{{ old('nombre', $user->nombre) }}"
               class="form-control @error('nombre') is-invalid @enderror">
        @error('nombre')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label>Nueva Contraseña (dejar en blanco si no cambia)</label>
        <input type="password" name="password"
               class="form-control @error('password') is-invalid @enderror">
      </div>

      <div class="mb-3">
        <label>Confirmar Contraseña</label>
        <input type="password" name="password_confirmation" class="form-control">
      </div>

      <button class="btn btn-primary">Guardar cambios</button>
    </form>
  </div>
</div>
@endsection
