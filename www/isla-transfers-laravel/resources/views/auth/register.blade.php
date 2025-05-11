@extends('layouts.app')

@section('title', 'Registro de Usuario')

@section('content')

<!-- Fuente profesional -->
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

<style>
  body {
    font-family: 'Open Sans', sans-serif;
    background: #f5f5f5;
  }
  .register-section {
    padding: 2rem 1rem;
    min-height: 70vh;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .register-card {
    background: #ffffff;
    border-radius: 0.75rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    padding: 2.5rem 2rem;
    width: 100%;
    max-width: 650px;
  }
  .register-card h3 {
    font-weight: 700;
    margin-bottom: 1.5rem;
    text-align: center;
    color: #333;
  }
  .form-label {
    font-weight: 600;
    color: #555;
  }
  .form-control {
    border: 1px solid #ddd;
    border-radius: 0.375rem;
    padding: 0.75rem 1rem;
    font-family: inherit;
    font-size: 1rem;
  }
  .form-control:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(40,167,69,0.25);
    border-color:rgb(43, 77, 121);
  }
  .btn-success {
    background:rgb(29, 78, 110);
    border: none;
    border-radius: 0.375rem;
    padding: 0.75rem;
    width: 100%;
    font-weight: 600;
    font-size: 1rem;
    color: #fff;
  }
  .btn-success:hover {
    background:rgb(20, 84, 98);
  }
  .text-center a {
    color:rgb(38, 72, 89);
    text-decoration: none;
  }
  .text-center a:hover {
    text-decoration: underline;
  }
</style>

<section class="register-section">
  <div class="register-card">
    <h3>Registro de nuevo usuario</h3>

    @if ($errors->any())
      <div class="alert alert-danger" role="alert">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('register.submit') }}" method="POST">
      @csrf

      <div class="row mb-3">
        <div class="col-md-6">
          <label for="nombre" class="form-label">Nombre</label>
          <input id="nombre" type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
        </div>
        <div class="col-md-6">
          <label for="email" class="form-label">Correo Electrónico</label>
          <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label for="apellido1" class="form-label">Apellido 1</label>
          <input id="apellido1" type="text" name="apellido1" class="form-control" value="{{ old('apellido1') }}" required>
        </div>
        <div class="col-md-6">
          <label for="apellido2" class="form-label">Apellido 2</label>
          <input id="apellido2" type="text" name="apellido2" class="form-control" value="{{ old('apellido2') }}">
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label for="direccion" class="form-label">Dirección</label>
          <input id="direccion" type="text" name="direccion" class="form-control" value="{{ old('direccion') }}" required>
        </div>
        <div class="col-md-3">
          <label for="codigoPostal" class="form-label">Código Postal</label>
          <input id="codigoPostal" type="text" name="codigoPostal" class="form-control" value="{{ old('codigoPostal') }}" required>
        </div>
        <div class="col-md-3">
          <label for="ciudad" class="form-label">Ciudad</label>
          <input id="ciudad" type="text" name="ciudad" class="form-control" value="{{ old('ciudad') }}" required>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-md-6">
          <label for="pais" class="form-label">País</label>
          <input id="pais" type="text" name="pais" class="form-control" value="{{ old('pais') }}" required>
        </div>
        <div class="col-md-6">
          <label for="password" class="form-label">Contraseña</label>
          <input id="password" type="password" name="password" class="form-control" required>
        </div>
      </div>

      <div class="mb-4">
        <label for="password_confirmation" class="form-label">Repetir Contraseña</label>
        <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
      </div>

      <div class="d-grid mb-3">
        <button type="submit" class="btn btn-success">
          <i class="fas fa-user-plus me-2"></i> Registrar
        </button>
      </div>

      <div class="text-center">
        ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
      </div>
    </form>
  </div>
</section>

@endsection
