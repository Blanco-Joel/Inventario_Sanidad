<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GestionMaterialesController extends Controller
{
//--------------------------------------------------------------------------
    /**
     * Muestra la vista principal de gestión de materiales.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showGestionMateriales()
    {
        return view('gestionMateriales');
    }
//--------------------------------------------------------------------------
    /**
     * Muestra la vista para dar de alta (agregar) nuevos materiales.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showAltaMateriales()
    {
        return view('altaMaterial');
    }

    /**
     * Da de alta los materiales que se han almacenado temporalmente en la cookie 
     * 'cestaMaterialesAlta'. Si ocurre un error no se da de alta ningún material.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function altaMaterial()
    {
        // Se obtiene el contenido de la cookie 'cestaMaterialesAlta' en formato JSON.
        // Si no existe, se retorna '[]' (un array vacío serializado en JSON).
        $cesta = Cookie::get('cestaMaterialesAlta', '[]');

        // Se decodifica el JSON para obtener un array asociativo.
        $cesta = json_decode($cesta, true);
        if (!is_array($cesta)) {
            $cesta = [];
        }

        // Si la cesta está vacía, se retorna un error.
        if (empty($cesta)) {
            return back()->with('error', 'No hay materiales en la cesta para dar de alta.');
        }

        try {
            // Se utiliza una transacción para asegurarse de que todas las inserciones se hagan juntas.
            DB::transaction(function () use ($cesta) {
                foreach ($cesta as $materialData) {
                    // Se crea una nueva instancia del modelo Material para cada entrada.
                    $material = new Material();
                    // Se genera un nuevo ID basado en los registros existentes.
                    $material->id_material = $this->generarNuevoIDMaterial();
                    // Se establece el 'nombre' y la 'descripcion' guardados en la cookie.
                    $material->nombre = $materialData["nombre"];
                    $material->descripcion = $materialData["descripcion"];
                    // Se guarda el material en la base de datos.
                    $material->save();
                }
            });

            // Si la transacción fue exitosa, se elimina la cookie 'cestaMaterialesAlta'.
            Cookie::queue(Cookie::forget('cestaMaterialesAlta'));

            // Retorna atrás con un mensaje de éxito.
            return back()->with('success', 'Materiales incorporados correctamente.');
        } catch (\Exception $e) {
            // En caso de error, se retorna un mensaje sin eliminar la cookie para permitir reintentos.
            return back()->with('error', 'Error al insertar los materiales: ' . $e->getMessage());
        }
    }

    /**
     * Genera un nuevo identificador único para un material.
     * @return string
     */
    private function generarNuevoIDMaterial()
    {
        // Extrae la parte numérica de los IDs existentes que tienen el formato materialXXX.
        $ultimoNumero = Material::lockForUpdate()->selectRaw("CAST(SUBSTRING(id_material, 9) AS UNSIGNED) as num")->orderByDesc('num')->value('num');

        // Si no se encuentra ningún registro, se usa 0 y se suma 1 independientemente del resultado.
        $siguienteNumero = ($ultimoNumero ?? 0) + 1;

        // Devolver el nuevo ID con el formato materialXXX.
        return 'material' . str_pad($siguienteNumero, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Agrega un nuevo material a la cesta para dar de alta.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function agregarMaterialACestaAlta(Request $request)
    {
        // Valida que se manden el nombre y la descripción del material.
        $validated = $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
        ], [
            'nombre.required' => 'Debe introducir el nombre del material.',
            'descripcion.required' => 'Debe introducir la descripción del material.',
        ]);

        // Se obtiene la cookie 'cestaMaterialesAlta', o '[]' por defecto, ambos arrays en formato JSON.
        $cesta = Cookie::get('cestaMaterialesAlta', '[]');
        // Decodificar el array e indicar que es un array asociativo.
        $cesta = json_decode($cesta, true);
        // Si la cesta no es un array debido a un error se convierte en un array vacío.
        if (!is_array($cesta)) {
            $cesta = [];
        }

        // Se agrega un nuevo material a la cesta como un array asociativo.
        $cesta[] = [
            'nombre'      => $validated['nombre'],
            'descripcion' => $validated['descripcion'],
        ];
        
        // Se vuelve a codificar el array a JSON y se guarda en la cookie por 1440 minutos (24 horas).
        Cookie::queue('cestaMaterialesAlta', json_encode($cesta), 1440);
        
        // Retorna atrás con un mensaje de éxito.
        return back()->with('success', 'Material agregado a la cesta.');
    }
//--------------------------------------------------------------------------
    /**
     * Muestra la vista para dar de baja (eliminar) materiales.
     * @return mixed|\Illuminate\Contracts\View\View
     */
    public function showBajaMateriales()
    {
        return view('bajaMaterial')->with('materiales', Material::all());
    }

    /**
     * Agrega un material a la cesta para dar de baja, almacenando su ID.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function agregarMaterialACestaBaja(Request $request)
    {
        // Se obtiene la cookie 'cestaMaterialesBaja', o '[]' por defecto, ambos arrays en formato JSON.
        $cesta = Cookie::get('cestaMaterialesBaja', '[]');
        // Decodificar el array e indicar que es un array asociativo.
        $cesta = json_decode($cesta, true);
        // Si la cesta no es un array debido a un error se convierte en un array vacío.
        if (!is_array($cesta)) {
            $cesta = [];
        }

        // Se agrega el id del material.
        $cesta[] = [
            'id_material' => $request->input('material')
        ];
        
        // Se actualiza la cookie 'cestaMaterialesBaja' con el nuevo contenido codificado en JSON.
        Cookie::queue('cestaMaterialesBaja', json_encode($cesta), 1440);
        
        // Retorna atrás con un mensaje de éxito.
        return back()->with('success', 'Material agregado a la cesta.');
    }

    /**
     * Da de baja (elimina) los materiales cuyos IDs están almacenados en la cookie
     * 'cestaMaterialesBaja'. Si ocurre un error no se da de baja ningún material.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bajaMaterial()
    {
        // Se obtiene la cookie 'cestaMaterialesBaja', o '[]' por defecto, ambos arrays en formato JSON.
        $cesta = Cookie::get('cestaMaterialesBaja', '[]');
        // Decodificar el array e indicar que es un array asociativo.
        $cesta = json_decode($cesta, true);
        // Si la cesta no es un array debido a un error se convierte en un array vacío.
        if (!is_array($cesta)) {
            $cesta = [];
        }

        // Si la cesta está vacía, se retorna un error.
        if (empty($cesta)) {
            return back()->with('error', 'No hay materiales en la cesta para dar de baja.');
        }

        try {
            // Se utiliza una transacción para asegurarse de que todas las eliminaciones se hagan juntas.
            DB::transaction(function () use ($cesta) {
                foreach ($cesta as $item) {
                    // Se busca el material en la base de datos usando el ID almacenado en la cookie.
                    $material = Material::find($item['id_material']);
                    if ($material) {
                        // Si se encuentra el material, se elimina.
                        $material->delete();
                    }
                }
            });

            // Si la transacción fue exitosa, se elimina la cookie 'cestaMaterialesBaja'.
            Cookie::queue(Cookie::forget('cestaMaterialesBaja'));

            // Retorna atrás con un mensaje de éxito.
            return back()->with('success', 'Materiales eliminados correctamente.');
        } catch (\Exception $e) {
            // En caso de error, se retorna un mensaje sin eliminar la cookie para permitir reintentos.
            return back()->with('error', 'Error al eliminar los materiales: ' . $e->getMessage());
        }
    }
//--------------------------------------------------------------------------
}
