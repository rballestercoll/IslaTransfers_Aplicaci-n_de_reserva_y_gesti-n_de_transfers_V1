<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransferZona;

class AdminZonaController extends Controller
{
    public function index()
    {
        $zonas = TransferZona::all();
        return view('admin.zonas.index', compact('zonas'));
    }

    public function edit($id)
    {
        $zona = TransferZona::findOrFail($id);
        return view('admin.zonas.edit', compact('zona'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
        ]);

        $zona = TransferZona::findOrFail($id);
        $zona->descripcion = $request->descripcion;
        $zona->save();

        return redirect('/admin/zonas')->with('success', 'Zona actualizada correctamente');
    }
}
