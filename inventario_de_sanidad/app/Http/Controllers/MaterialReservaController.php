<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaterialReservaController extends Controller
{
    public function showSubmenuHistorial(Request $request)
    {
        return view('materiales.submenuHistorial');
    }
    public function showHistorialModificaciones(Request $request)
    {
        $modifications = DB::table('modifications')
        ->join('users', 'modifications.user_id', '=', 'users.user_id')
        ->join('materials', 'modifications.material_id', '=', 'materials.material_id')
        ->select('users.first_name', 'users.last_name', 'users.email', 'users.user_type', 'users.created_at',
                 'materials.name as material_name', 'modifications.units', 'modifications.action_datetime', 'modifications.storage_type')
        ->get();
    
        return view('materiales.historialModificaciones', ['modifications' => $modifications]);
    }
    public function index(Request $request, $tipo)
    {
        $tipo2 = $tipo == "uso" ? "use" : "reserve";
        // Consulta base
        $query = DB::table('storages')
            ->join('materials', 'storages.material_id', '=', 'materials.material_id')
            ->select(
                'materials.material_id',
                'materials.name',
                'materials.description',
                'materials.image_path',
                'storages.cabinet',
                'storages.shelf',
                'storages.units',
                'storages.min_units'
            )
            ->where('storages.storage_type', $tipo2);
    
        // Filtro opcional por búsqueda
        if ($request->has('busqueda') && !empty($request->busqueda)) {
            $busqueda = $request->busqueda;
            $query->where('materials.name', 'like', '%' . $busqueda . '%');
        }
    
        $materiales = $query->get();
    
        // Vista dinámica: materiales.uso o materiales.reserva
        return view("materiales.$tipo", compact('materiales'));
    }
}
