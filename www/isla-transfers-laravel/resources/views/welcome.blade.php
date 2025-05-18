@extends('layouts.app')

@section('title', 'Isla Transfers')

@section('content')

<!-- Fuentes y estilo general -->
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
<style>
  body {
    font-family: 'Open Sans', sans-serif;
    background: #ffffff;
    color: #333;
  }
  section {
    padding: 4rem 1rem;
    max-width: 1200px;
    margin: 0 auto;
  }

  /* --- Hero --- */
  .hero {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
  }
  .hero h1 {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1rem;
  }
  .hero p {
    font-size: 1.25rem;
    margin-bottom: 2rem;
  }
  .hero .btn {
    margin: 0 .5rem;
    min-width: 160px;
  }

  /* --- Collage de imágenes --- */
  .gallery {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    grid-gap: 1rem;
  }
  .gallery img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: .5rem;
  }

  /* --- Explicativa --- */
  .about {
    display: flex;
    flex-wrap: wrap;
    gap: 2rem;
    align-items: center;
  }
  .about .text {
    flex: 1 1 300px;
  }
  .about .text h2 {
    font-size: 2rem;
    margin-bottom: 1rem;
  }
  .about .text p {
    line-height: 1.6;
  }
  .about .image {
    flex: 1 1 300px;
  }
  .about .image img {
    width: 100%;
    border-radius: .5rem;
  }

  /* --- Opiniones --- */
  .testimonials {
    background: #f5f5f5;
    border-radius: .5rem;
  }
  .testimonials h2 {
    text-align: center;
    margin-bottom: 2rem;
    font-size: 2rem;
  }
  .testimonial-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
  }
  .testimonial {
    background: #fff;
    padding: 2rem;
    border-radius: .5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  }
  .testimonial p {
    font-style: italic;
    margin-bottom: 1rem;
  }
  .testimonial .author {
    text-align: right;
    font-weight: 600;
  }

  /* --- Contacto --- */
  .contact h2 {
    text-align: center;
    margin-bottom: 2rem;
    font-size: 2rem;
  }
  .contact form {
    max-width: 600px;
    margin: 0 auto;
    display: grid;
    gap: 1rem;
  }
  .contact input,
  .contact textarea {
    width: 100%;
    padding: .75rem;
    border: 1px solid #ccc;
    border-radius: .25rem;
    font-family: inherit;
  }
  .contact button {
    align-self: start;
    padding: .75rem 1.5rem;
    border: none;
    background: #007bff;
    color: #fff;
    border-radius: .25rem;
    font-weight: 600;
  }
</style>

{{-- Hero --}}
<section class="hero">
  <h1>Isla Transfers</h1>
  <p>Tu solución confiable para traslados aeropuerto–hotel en las Islas.</p>
  <div>
    <a href="{{ route('login') }}" class="btn btn-primary">Iniciar sesión</a>
    <a href="{{ route('register') }}" class="btn btn-outline-primary">Registro</a>
  </div>
</section>

{{-- Collage de imágenes --}}
<section class="gallery">
  <img src="{{ asset('images/Transfer1.png') }}" alt="Transfer 1">
  <img src="{{ asset('images/Transfer2.png') }}" alt="Transfer 2">
  <img src="{{ asset('images/Transfer3.png') }}" alt="Transfer 3">
  <img src="{{ asset('images/Transfer4.png') }}" alt="Transfer 4">
  <img src="{{ asset('images/Transfer5.png') }}" alt="Transfer 5">
</section>

{{-- Sección explicativa --}}
<section class="about">
  <div class="text">
    <h2>¿Por qué elegirnos?</h2>
    <p>
      En Isla Transfers nos especializamos en ofrecerte traslados puntuales y seguros desde y hacia los aeropuertos
      de las islas. Nuestro equipo con experiencia local te garantiza comodidad y tranquilidad desde el primer momento.
      Vehículos modernos, conductores profesionales y asistencia 24/7 son solo algunas de nuestras ventajas.
    </p>
  </div>
  <div class="image">
    <img src="{{ asset('images/about_transfer.png') }}" alt="Conductor profesional">
  </div>
</section>

{{-- Opiniones de clientes --}}
<section class="testimonials">
  <h2>Lo que dicen nuestros clientes</h2>
  <div class="testimonial-list">
    <div class="testimonial">
      <p>"Excelente servicio, puntualidad y trato inmejorable. ¡Repetiré sin duda!"</p>
      <div class="author">— María G.</div>
    </div>
    <div class="testimonial">
      <p>"Viajar con Isla Transfers fue la mejor decisión. El coche impecable y el conductor muy amable."</p>
      <div class="author">— Juan P.</div>
    </div>
    <div class="testimonial">
      <p>"Reservar fue facilísimo y el precio muy competitivo. ¡Totalmente recomendado!"</p>
      <div class="author">— Laura R.</div>
    </div>
  </div>
</section>

{{-- Sección explicativa --}}
<section class="about">
  <div class="image">
    <img src="{{ asset('images/about_transfer2.png') }}" alt="Conductor profesional">
  </div>
  <div class="text">
    <h2>Deja el camino en nuestras manos</h2>
    <p>
      Relájate y despreocúpate: en Isla Transfers nos encargamos de todos los detalles. 
  Nuestros conductores profesionales, con profundo conocimiento de las islas, 
  y una flota moderna te ofrecen traslados sin sorpresas. Disfruta del viaje, 
  nosotros nos ocupamos del resto.
    </p>
  </div>

</section>


@endsection
