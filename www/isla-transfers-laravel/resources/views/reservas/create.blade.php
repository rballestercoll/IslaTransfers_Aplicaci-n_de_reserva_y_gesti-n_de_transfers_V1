@extends('layouts.app')

@section('title','Nueva Reserva')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <h2>Crear Nueva Reserva</h2>

    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('reservas.store') }}">
      @csrf

      <div class="mb-3">
        <label for="id_tipo_reserva" class="form-label">Tipo de Trayecto</label>
        <select name="id_tipo_reserva" id="id_tipo_reserva"
                class="form-select @error('id_tipo_reserva') is-invalid @enderror">
          <option value="">-- Selecciona --</option>
          @foreach($tipos as $tipo)
            <option value="{{ $tipo->id_tipo_reserva }}"
              {{ old('id_tipo_reserva') == $tipo->id_tipo_reserva ? 'selected' : '' }}>
              {{ $tipo->descripcion }}
            </option>
          @endforeach
        </select>
        @error('id_tipo_reserva')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Aeropuerto → Hotel --}}
      <div id="trayecto_1" class="trayecto mb-3 p-3 border rounded">
        <h5>Aeropuerto → Hotel</h5>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Día de llegada</label>
            <input type="date" name="fecha_entrada" class="form-control @error('fecha_entrada') is-invalid @enderror"
                   value="{{ old('fecha_entrada') }}">
            @error('fecha_entrada')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Hora de llegada</label>
            <input type="time" name="hora_entrada" class="form-control @error('hora_entrada') is-invalid @enderror"
                   value="{{ old('hora_entrada') }}">
            @error('hora_entrada')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Número de vuelo (entrada)</label>
          <input type="text" name="numero_vuelo_entrada"
                 class="form-control @error('numero_vuelo_entrada') is-invalid @enderror"
                 value="{{ old('numero_vuelo_entrada') }}">
          @error('numero_vuelo_entrada')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Aeropuerto de origen</label>
          <input type="text" name="origen_vuelo_entrada"
                 class="form-control @error('origen_vuelo_entrada') is-invalid @enderror"
                 value="{{ old('origen_vuelo_entrada') }}">
          @error('origen_vuelo_entrada')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
      </div>

      {{-- Hotel → Aeropuerto --}}
      <div id="trayecto_2" class="trayecto mb-3 p-3 border rounded">
        <h5>Hotel → Aeropuerto</h5>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label">Fecha del vuelo (salida)</label>
            <input type="date" name="fecha_vuelo_salida"
                   class="form-control @error('fecha_vuelo_salida') is-invalid @enderror"
                   value="{{ old('fecha_vuelo_salida') }}">
            @error('fecha_vuelo_salida')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label">Hora del vuelo (salida)</label>
            <input type="time" name="hora_vuelo_salida"
                   class="form-control @error('hora_vuelo_salida') is-invalid @enderror"
                   value="{{ old('hora_vuelo_salida') }}">
            @error('hora_vuelo_salida')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label">Número de vuelo (salida)</label>
          <input type="text" name="numero_vuelo_salida"
                 class="form-control @error('numero_vuelo_salida') is-invalid @enderror"
                 value="{{ old('numero_vuelo_salida') }}">
          @error('numero_vuelo_salida')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Hora de recogida</label>
          <input type="time" name="hora_recogida"
                 class="form-control @error('hora_recogida') is-invalid @enderror"
                 value="{{ old('hora_recogida') }}">
          @error('hora_recogida')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
      </div>

      <div class="row">
        <div class="col-md-4 mb-3">
          <label class="form-label">Hotel</label>
          <select name="id_hotel" class="form-select @error('id_hotel') is-invalid @enderror">
            <option value="">-- Selecciona hotel --</option>
            @foreach($hoteles as $h)
              <option value="{{ $h->id_hotel }}"
                {{ old('id_hotel')==$h->id_hotel?'selected':'' }}>
                {{ $h->descripcion }}
              </option>
            @endforeach
          </select>
          @error('id_hotel')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-4 mb-3">
          <label class="form-label">Destino (hotel)</label>
          <select name="id_destino" class="form-select @error('id_destino') is-invalid @enderror">
            <option value="">-- Selecciona destino --</option>
            @foreach($hoteles as $h)
              <option value="{{ $h->id_hotel }}"
                {{ old('id_destino')==$h->id_hotel?'selected':'' }}>
                {{ $h->descripcion }}
              </option>
            @endforeach
          </select>
          @error('id_destino')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-4 mb-3">
          <label class="form-label">Vehículo</label>
          <select name="id_vehiculo" class="form-select @error('id_vehiculo') is-invalid @enderror">
            <option value="">-- Selecciona vehículo --</option>
            @foreach($vehiculos as $v)
              <option value="{{ $v->id_vehiculo }}"
                {{ old('id_vehiculo')==$v->id_vehiculo?'selected':'' }}>
                {{ $v->descripcion }}
              </option>
            @endforeach
          </select>
          @error('id_vehiculo')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Número de viajeros</label>
        <input type="number" name="num_viajeros" min="1"
               class="form-control @error('num_viajeros') is-invalid @enderror"
               value="{{ old('num_viajeros',1) }}">
        @error('num_viajeros')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      <button class="btn btn-success">Guardar Reserva</button>
    </form>
  </div>
</div>

{{-- Script para mostrar/ocultar secciones --}}
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
