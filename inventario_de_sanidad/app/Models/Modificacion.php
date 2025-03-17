<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modificacion extends Model
{
    use HasFactory;

    // Definir la tabla si no sigue el nombre plural
    protected $table = 'modificaciones';

    public $timestamps = false;

    // Definir las claves primarias compuestas
    protected $primaryKey = ['id_usuario', 'id_material', 'fecha_accion'];

    // Desactivar el incremento automático
    public $incrementing = false;

    // Atributos que se pueden asignar de forma masiva
    protected $fillable = [
        'id_usuario', 'id_material', 'fecha_accion', 'accion', 'unidades', 'tipo_almacen',
    ];

    // Relación con el modelo Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    // Relación con el modelo Material
    public function material()
    {
        return $this->belongsTo(Material::class, 'id_material', 'id_material');
    }
}
