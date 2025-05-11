<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TransferReserva;

class ReservaController extends Controller
{
    public function index()
    {
        $reservas = TransferReserva::with(['vehiculo', 'destinoHotel'])->get();
        $formateadas = [];

        foreach ($reservas as $reserva) {
            // Detectar tipo de trayecto: 1 = ida, 2 = vuelta, 3 = ida y vuelta
            $tipo_trayecto = 3;
            if ($reserva->fecha_entrada && !$reserva->fecha_vuelo_salida) {
                $tipo_trayecto = 1;
            } elseif (!$reserva->fecha_entrada && $reserva->fecha_vuelo_salida) {
                $tipo_trayecto = 2;
            }

            $baseTitle = "{$reserva->localizador} - {$reserva->destinoHotel->nombre_hotel} - {$reserva->email_cliente}";

            if ($reserva->fecha_entrada) {
                $formateadas[] = [
                    'id' => $reserva->id_reserva . '-ida',
                    'title' => $baseTitle . ' (IDA)',
                    'start' => $reserva->fecha_entrada . 'T' . ($reserva->hora_entrada ?? '00:00:00'),
                    'color' => $reserva->fecha_vuelo_salida ? '#28a745' : '#007bff',
                    'extendedProps' => [
                        'tipo_trayecto' => $tipo_trayecto,
                    ],
                ];
            }

            if ($reserva->fecha_vuelo_salida) {
                $formateadas[] = [
                    'id' => $reserva->id_reserva . '-vuelta',
                    'title' => $baseTitle . ' (VUELTA)',
                    'start' => $reserva->fecha_vuelo_salida . 'T' . ($reserva->hora_vuelo_salida ?? '00:00:00'),
                    'color' => $reserva->fecha_entrada ? '#28a745' : '#dc3545',
                    'extendedProps' => [
                        'tipo_trayecto' => $tipo_trayecto,
                    ],
                ];
            }
        }

        return response()->json($formateadas);
    }
}
