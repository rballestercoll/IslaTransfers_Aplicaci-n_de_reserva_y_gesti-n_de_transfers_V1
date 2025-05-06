@extends('layouts.app')

@section('title','Inicio')

@section('content')
  {{-- Sección de Presentación --}}
  <section class="presentacion text-center py-5 bg-white rounded shadow-sm">
    <h2 class="mb-4">Bienvenido a Isla Transfers</h2>
    <p class="lead mb-4">
      Te ofrecemos traslados cómodos y seguros desde el aeropuerto hasta tu hotel y viceversa.
      Nuestro objetivo es brindarte la mejor experiencia de viaje en la isla.
    </p>

    @guest
      <a href="{{ route('login') }}" class="btn btn-primary me-2">Inicia Sesión</a>
      <a href="{{ route('register') }}" class="btn btn-success">Regístrate</a>
    @else
      @if(auth()->user()->rol === 'admin')
        <a href="{{ route('admin.create') }}" class="btn btn-primary">Crear Reserva</a>
      @elseif(auth()->user()->rol === 'corporativo')
        <a href="{{ route('corporativo.dashboard') }}" class="btn btn-primary">Panel Hotel</a>
      @else
        <a href="{{ route('reservas.index') }}" class="btn btn-primary">Mis Reservas</a>
      @endif
    @endguest
  </section>

  {{-- Sección Info Destacada --}}
  <section class="info-destacada mt-5 p-4 bg-white rounded shadow-sm">
    <h3 class="mb-3">¿Por qué elegirnos?</h3>
    <ul class="list-unstyled">
      <li>✔ Flota de vehículos moderna</li>
      <li>✔ Conductores profesionales</li>
      <li>✔ Reservas fáciles y rápidas</li>
      <li>✔ Servicio 24/7</li>
    </ul>
  </section>

  <div id="heroCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="/images/slide1.jpg" class="d-block w-100" alt="Slide 1">
    </div>
    <div class="carousel-item">
      <img src="/images/slide2.jpg" class="d-block w-100" alt="Slide 2">
    </div>
    <div class="carousel-item">
      <img src="/images/slide3.jpg" class="d-block w-100" alt="Slide 3">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

  {{-- Sección de Testimonios --}}
  <section class="testimonios mt-5 p-4 bg-white rounded shadow-sm">
    <h3 class="mb-3">Lo que dicen nuestros clientes</h3>
    <div class="row">
      <div class="col-md-4">
        <blockquote class="blockquote">
          <p class="mb-0">"El mejor servicio de traslados que he utilizado. ¡Recomendado!"</p>
          <footer class="blockquote-footer">
            Juan Pérez, <cite title="Source Title">Cliente Satisfecho</cite>
          </footer>
@endsection



