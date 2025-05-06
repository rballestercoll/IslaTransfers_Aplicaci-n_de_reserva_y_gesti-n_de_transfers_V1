@extends('layouts.app')

@section('title','Iniciar Sesión')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <h2>Iniciar Sesión</h2>
    <form method="POST" action="{{ route('login') }}">
      @csrf

      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}"
               class="form-control @error('email') is-invalid @enderror" required autofocus>
        @error('email')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label>Contraseña</label>
        <input type="password" name="password"
               class="form-control @error('password') is-invalid @enderror" required>
        @error('password')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <button class="btn btn-primary">Entrar</button>
    </form>
    <p class="mt-3">
      ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a>
    </p>
  </div>
</div>
@endsection
