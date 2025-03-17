<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacenamiento extends Model
{
    use HasFactory;

    // Definir la tabla si no sigue el nombre plural
    protected $table = 'almacenamiento';

    public $timestamps = false;

    // Definir las claves primarias compuestas
    protected $primaryKey = ['id_material', 'tipo_almacen'];

    // Desactivar el incremento automático
    public $incrementing = false;

    // Atributos que se pueden asignar de forma masiva
    protected $fillable = [
        'id_material', 'tipo_almacen', 'armario', 'balda', 'unidades',
    ];

    // Relación con el modelo Material
    public function material()
    {
        return $this->belongsTo(Material::class, 'id_material', 'id_material');
    }
}
