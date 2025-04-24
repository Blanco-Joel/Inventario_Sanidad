<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaterialReservaController extends Controller
{
    public function index(Request $request)
    {
        // Inicializamos la consulta base
        $query = DB::table('almacenamiento')
            ->join('materiales', 'almacenamiento.id_material', '=', 'materiales.id_material')
            ->select(
                'materiales.id_material',
                'materiales.nombre',
                'materiales.descripcion',
                'materiales.ruta_imagen',
                'almacenamiento.armario',
                'almacenamiento.balda',
                'almacenamiento.unidades',
                'almacenamiento.min_unidades'
            )
            ->where('tipo_almacen', 'reserva');

        // Si existe un parámetro de búsqueda, lo agregamos a la consulta
        if ($request->has('busqueda') && !empty($request->busqueda)) {
            $busqueda = $request->busqueda;
            $query->where('materiales.nombre', 'like', '%' . $busqueda . '%');
        }

        // Obtener los resultados filtrados
        $materialesReserva = $query->get();

        return view('materiales.reserva', compact('materialesReserva'));
    }
}
