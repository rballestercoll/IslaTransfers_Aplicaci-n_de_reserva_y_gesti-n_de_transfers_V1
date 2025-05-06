<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>@yield('title','Isla Transfers')</title>

  <!-- 1) Bootstrap CSS via CDN -->
  <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-…" crossorigin="anonymous">

  <!-- 2) Tus overrides ligeros -->
  <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body class="bg-light">

  @include('partials.header')

  <main class="container py-4">
    @if(session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @yield('content')
  </main>

  @include('partials.footer')

  <!-- Bootstrap JS Bundle -->
  <script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.4.0/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-…" crossorigin="anonymous"></script>
</body>
</html>
