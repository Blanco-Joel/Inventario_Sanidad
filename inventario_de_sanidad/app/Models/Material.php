<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    // Definir la tabla si no sigue el nombre plural
    protected $table = 'materiales';

    public $timestamps = false;

    // Definir la clave primaria
    protected $primaryKey = 'id_material';

    // Definir si la clave primaria es un valor auto-incrementable
    public $incrementing = false;

    // Atributos que se pueden asignar de forma masiva
    protected $fillable = [
        'id_material', 'nombre',
    ];

    // Relación con el modelo de Almacenamiento
    public function almacenamiento()
    {
        return $this->hasMany(Almacenamiento::class, 'id_material', 'id_material');
    }

    // Relación con el modelo de Modificaciones
    public function modificaciones()
    {
        return $this->hasMany(Modificacion::class, 'id_material', 'id_material');
    }
}
