<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}">Isla Transfers</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
            data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto">
        @guest
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrarse</a></li>
        @else
          @if(auth()->user()->rol==='admin')
          <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Panel Admin</a></li>
          @elseif(auth()->user()->rol==='corporativo')
          <li class="nav-item"><a class="nav-link" href="{{ route('corporativo.dashboard') }}">Panel Hotel</a></li>
          @else
          <li class="nav-item"><a class="nav-link" href="{{ route('reservas.index') }}">Mis Reservas</a></li>
          @endif
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="nav-link btn btn-link">Cerrar sesión</button>
            </form>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
