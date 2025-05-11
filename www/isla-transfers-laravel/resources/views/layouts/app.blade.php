<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Isla Transfers')</title>

  <!-- Google Font profesional -->
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Estilos personalizados minimalistas -->
  <style>
    body {
      font-family: 'Open Sans', sans-serif;
      background: #f9f9f9;
    }
    .navbar {
      background: #ffffff;
      border-bottom: 1px solid #eaeaea;
      position: relative;
      padding-top: 0.7rem;
      padding-bottom: 0.7rem;
    }
    .navbar-brand {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      font-weight: 700;
      font-size: 1.5rem;
      color: #222222 !important;
      z-index: 2;
    }
    .navbar-collapse {
    padding-top: 1.7rem;
    margin-top: 1.5rem;       /* empuja el menú hacia abajo */
    z-index: 1;                /* menú por debajo de la marca */
    justify-content: center;
  }
    .nav-link {
      color: #555555 !important;
      font-weight: 500;
      padding: 0.5rem 1rem;
    }
    .navbar-toggler {
      border: none;
    }
    .navbar-toggler-icon {
      filter: invert(30%);
    }
    .dropdown-menu {
      border-radius: 0.5rem;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <!-- Marca centrada -->
      <a class="navbar-brand" href="{{ route('welcome') }}">Isla Transfers</a>

      <!-- Botón móvil -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Menú -->
      <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <ul class="navbar-nav">
          @if (session('id_admin'))
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.panel') }}">Inicio</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.reservas.list') }}">Reservas</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.hoteles.index') }}">Hoteles</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.vehiculos.index') }}">Vehículos</a></li>
          @elseif (session('id_viajero'))
            <li class="nav-item"><a class="nav-link" href="{{ route('customer.panel') }}">Inicio</a></li>
          @elseif (session('id_hotel'))
            <li class="nav-item"><a class="nav-link" href="{{ route('corp.panel') }}">Inicio</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('hotel.comisiones') }}">Comisiones</a></li>
          @else
            <li class="nav-item"><a class="nav-link" href="{{ route('welcome') }}">Inicio</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registro</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
          @endif
        </ul>

        @if (session('email'))
          <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                {{ session('email') }}
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Editar perfil</a></li>
                <li>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="dropdown-item" type="submit">Cerrar sesión</button>
                  </form>
                </li>
              </ul>
            </li>
          </ul>
        @endif
      </div>
    </div>
  </nav>

  <div class="container mt-4">
    @yield('content')
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>
