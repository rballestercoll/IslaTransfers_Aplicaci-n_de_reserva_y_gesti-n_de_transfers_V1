@extends('layouts.app')

@section('title','Registro de Usuario')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <h2>Registro de Usuario</h2>
    <form method="POST" action="{{ route('register') }}">
      @csrf

      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}"
               class="form-control @error('email') is-invalid @enderror" required>
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label>Contraseña</label>
        <input type="password" name="password"
               class="form-control @error('password') is-invalid @enderror" required>
      </div>

      <div class="mb-3">
        <label>Confirmar Contraseña</label>
        <input type="password" name="password_confirmation" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Nombre (opcional)</label>
        <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control">
      </div>

      <div class="mb-3">
        <label>Tipo de usuario</label>
        <select name="rol" class="form-select">
          <option value="particular" {{ old('rol')=='particular'?'selected':'' }}>Particular</option>
          <option value="corporativo" {{ old('rol')=='corporativo'?'selected':'' }}>Corporativo</option>
        </select>
      </div>

      <button class="btn btn-success">Registrarse</button>
    </form>
    <p class="mt-3">
      ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
    </p>
  </div>
</div>
@endsection
