@extends('layouts.app')

@section('title','Editar Reserva')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <h2>Editar Reserva {{ $reserva->localizador }}</h2>

    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('reservas.update',$reserva) }}">
      @csrf @method('PUT')

      <div class="mb-3">
        <label class="form-label">Tipo de Trayecto</label>
        <select name="id_tipo_reserva" id="id_tipo_reserva"
                class="form-select @error('id_tipo_reserva') is-invalid @enderror">
          @foreach($tipos as $tipo)
            <option value="{{ $tipo->id_tipo_reserva }}"
              {{ old('id_tipo_reserva',$reserva->id_tipo_reserva)==$tipo->id_tipo_reserva?'selected':'' }}>
              {{ $tipo->descripcion }}
            </option>
          @endforeach
        </select>
        @error('id_tipo_reserva')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      {{-- Repite los mismos bloques de trayecto_1 y trayecto_2, pero con value="{{ old(...,$reserva->... ) }}" --}}
      {{-- Aeropuerto→Hotel --}}
      <div id="trayecto_1" class="trayecto mb-3 p-3 border rounded">
        <h5>Aeropuerto → Hotel</h5>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label>Fecha entrada</label>
            <input type="date" name="fecha_entrada"
                   class="form-control @error('fecha_entrada') is-invalid @enderror"
                   value="{{ old('fecha_entrada',$reserva->fecha_entrada) }}">
            @error('fecha_entrada')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6 mb-3">
            <label>Hora entrada</label>
            <input type="time" name="hora_entrada"
                   class="form-control @error('hora_entrada') is-invalid @enderror"
                   value="{{ old('hora_entrada',$reserva->hora_entrada) }}">
            @error('hora_entrada')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>
        <div class="mb-3">
          <label>Número vuelo entrada</label>
          <input type="text" name="numero_vuelo_entrada"
                 class="form-control @error('numero_vuelo_entrada') is-invalid @enderror"
                 value="{{ old('numero_vuelo_entrada',$reserva->numero_vuelo_entrada) }}">
          @error('numero_vuelo_entrada')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
          <label>Aeropuerto origen</label>
          <input type="text" name="origen_vuelo_entrada"
                 class="form-control @error('origen_vuelo_entrada') is-invalid @enderror"
                 value="{{ old('origen_vuelo_entrada',$reserva->origen_vuelo_entrada) }}">
          @error('origen_vuelo_entrada')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
      </div>

      {{-- Hotel→Aeropuerto --}}
      <div id="trayecto_2" class="trayecto mb-3 p-3 border rounded">
        <h5>Hotel → Aeropuerto</h5>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label>Fecha vuelo salida</label>
            <input type="date" name="fecha_vuelo_salida"
                   class="form-control @error('fecha_vuelo_salida') is-invalid @enderror"
                   value="{{ old('fecha_vuelo_salida',$reserva->fecha_vuelo_salida) }}">
            @error('fecha_vuelo_salida')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6 mb-3">
            <label>Hora vuelo salida</label>
            <input type="time" name="hora_vuelo_salida"
                   class="form-control @error('hora_vuelo_salida') is-invalid @enderror"
                   value="{{ old('hora_vuelo_salida',$reserva->hora_vuelo_salida) }}">
            @error('hora_vuelo_salida')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>
        <div class="mb-3">
          <label>Número vuelo salida</label>
          <input type="text" name="numero_vuelo_salida"
                 class="form-control @error('numero_vuelo_salida') is-invalid @enderror"
                 value="{{ old('numero_vuelo_salida',$reserva->numero_vuelo_salida) }}">
          @error('numero_vuelo_salida')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
          <label>Hora recogida</label>
          <input type="time" name="hora_recogida"
                 class="form-control @error('hora_recogida') is-invalid @enderror"
                 value="{{ old('hora_recogida',$reserva->hora_recogida) }}">
          @error('hora_recogida')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
      </div>

      {{-- Hoteles, destino, vehiculo, viajeros igual que create pero con old+reserva --}}
      {{-- ... copia y adapta los bloques de selección de hoteles/vehículos y num_viajeros ... --}}

      <h5>Datos de la reserva</h5>
      
      <div class="row">
        <div class="col-md-4 mb-3">
          <label class="form-label">Hotel</label>
          <select name="id_hotel"
                  class="form-select @error('id_hotel') is-invalid @enderror">
            <option value="">-- Selecciona hotel --</option>
            @foreach($hoteles as $h)
              <option value="{{ $h->id_hotel }}"
                {{ old('id_hotel', $reserva->id_hotel) == $h->id_hotel ? 'selected' : '' }}>
                {{ $h->descripcion }}
              </option>
            @endforeach
          </select>
          @error('id_hotel')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-4 mb-3">
          <label class="form-label">Destino (hotel)</label>
          <select name="id_destino"
                  class="form-select @error('id_destino') is-invalid @enderror">
            <option value="">-- Selecciona destino --</option>
            @foreach($hoteles as $h)
              <option value="{{ $h->id_hotel }}"
                {{ old('id_destino', $reserva->id_destino) == $h->id_hotel ? 'selected' : '' }}>
                {{ $h->descripcion }}
              </option>
            @endforeach
          </select>
          @error('id_destino')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-4 mb-3">
          <label class="form-label">Vehículo</label>
          <select name="id_vehiculo"
                  class="form-select @error('id_vehiculo') is-invalid @enderror">
            <option value="">-- Selecciona vehículo --</option>
            @foreach($vehiculos as $v)
              <option value="{{ $v->id_vehiculo }}"
                {{ old('id_vehiculo', $reserva->id_vehiculo) == $v->id_vehiculo ? 'selected' : '' }}>
                {{ $v->descripcion }}
              </option>
            @endforeach
          </select>
          @error('id_vehiculo')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Número de viajeros</label>
        <input type="number"
               name="num_viajeros"
               min="1"
               class="form-control @error('num_viajeros') is-invalid @enderror"
               value="{{ old('num_viajeros', $reserva->num_viajeros) }}">
        @error('num_viajeros')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>


      <button class="btn btn-primary">Actualizar Reserva</button>
    </form>
  </div>
</div>

@push('scripts')
<script>
  const tipo = document.getElementById('id_tipo_reserva');
  const s1 = document.getElementById('trayecto_1');
  const s2 = document.getElementById('trayecto_2');
  function toggleTrayectos() {
    const v = tipo.value;
    s1.style.display = (v==1||v==3)?'block':'none';
    s2.style.display = (v==2||v==3)?'block':'none';
  }
  tipo.addEventListener('change',toggleTrayectos);
  document.addEventListener('DOMContentLoaded',toggleTrayectos);
</script>
@endpush
@endsection
