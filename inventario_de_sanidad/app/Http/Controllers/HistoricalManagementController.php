<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoricalManagementController extends Controller
{
    public function showHistoricalSubmenu(Request $request)
    {
        return view('historical.historicalSubmenu');
    }
    public function modificationsHistoricalData()
    {
        $modifications = DB::table('modifications')
        ->join('users', 'modifications.user_id', '=', 'users.user_id')
        ->join('materials', 'modifications.material_id', '=', 'materials.material_id')
        ->select('users.first_name', 'users.last_name', 'users.email', 'users.user_type', 'users.created_at',
                 'materials.name as material_name', 'modifications.units', 'modifications.action_datetime', 'modifications.storage_type')
        ->orderBy("action_datetime",'desc')
        ->get();
        return response()->json($modifications);
    }


    public function showModificationsHistorical(Request $request)
    {
        return view('historical.modificationsHistorical');
    }
    public function index(Request $request, $type)
    {
        // Consulta base


        // Vista dinámica: historical.use o historical.reserve
        return view("historical.$type");
    }

    public function historicalData()
    {

        $materials = DB::table('storages')
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
            ->where('storages.storage_type', explode("=",url()->path()))
            ->get();
        return response()->json($materials);

    }
    
}
