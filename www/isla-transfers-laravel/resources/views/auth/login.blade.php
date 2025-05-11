@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')

<!-- Fuente profesional -->
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

<style>
  body {
    font-family: 'Open Sans', sans-serif;
    background: #f5f5f5;
  }
  .login-section {
    padding: 4rem 1rem;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .login-card {
    background: #ffffff;
    border-radius: 0.75rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    padding: 2.5rem 2rem;
    width: 100%;
    max-width: 420px;
  }
  .login-card h3 {
    font-weight: 700;
    margin-bottom: 1.5rem;
    text-align: center;
    color: #333;
  }
  .form-label {
    font-weight: 600;
    color: #555;
  }
  .form-control, .form-select {
    border: 1px solid #ddd;
    border-radius: 0.375rem;
    padding: 0.75rem 1rem;
    font-family: inherit;
    font-size: 1rem;
  }
  .form-control:focus, .form-select:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(0,123,255,0.25);
    border-color: #007bff;
  }
  .btn-primary {
    background: #007bff;
    border: none;
    border-radius: 0.375rem;
    padding: 0.75rem;
    width: 100%;
    font-weight: 600;
    font-size: 1rem;
  }
  .btn-primary:hover {
    background: #0069d9;
  }
  .text-center a {
    color: #007bff;
    text-decoration: none;
  }
  .text-center a:hover {
    text-decoration: underline;
  }
</style>



{{-- Contenido principal --}}
<div class="container py-5" style="margin-top: 80px; margin-bottom: 60px;">
  <div class="d-flex justify-content-center">
    <div class="glass-card">
      <form method="POST" action="{{ route('login.submit') }}">
        @csrf

        <div class="mb-4 text-center">
          <img src="{{ asset('images/login.jpg') }}" alt="LoginImage" style="width: 80px; height: auto;">
          <h3 class="mt-3 fw-bold">Iniciar sesión</h3>
        </div>

        @if ($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error:</strong> {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <div class="mb-3">
          <label for="user_type" class="form-label">Tipo de usuario</label>
          <select name="user_type" class="form-select" required>
            <option value="1">Cliente</option>
            <option value="2">Hotel</option>
            <option value="3">Administrador</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="inputEmail" class="form-label">Identificador (email o ID)</label>
          <input type="email" name="inputEmail" class="form-control" required>
          <div class="form-text">Nunca compartiremos su correo electrónico con nadie más.</div>
        </div>

        <div class="mb-4">
          <label for="inputPassword" class="form-label">Contraseña</label>
          <input type="password" name="inputPassword" class="form-control" required>
        </div>

        <button type="submit" name="submitLogin" class="btn btn-primary w-100 fw-bold">
          <i class="fas fa-sign-in-alt me-2"></i> Entrar
        </button>
      </form>
    </div>
  </div>
</div>

@endsection
