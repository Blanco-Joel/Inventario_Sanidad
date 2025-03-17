<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    // Definir la tabla si no sigue el nombre plural
    protected $table = 'usuarios';

    public $timestamps = false;
    
    // Definir la clave primaria
    protected $primaryKey = 'id_usuario';

    // Definir si la clave primaria es un valor auto-incrementable
    public $incrementing = false;

    // Definir los tipos de los atributos
    protected $casts = [
        'fecha_alta' => 'date',
    ];

    // Atributos que se pueden asignar de forma masiva
    protected $fillable = [
        'id_usuario', 'nombre', 'apellidos', 'fecha_alta', 'tipo_usuario',
    ];

    // Relación con el modelo de Modificaciones
    public function modificaciones()
    {
        return $this->hasMany(Modificacion::class, 'id_usuario', 'id_usuario');
    }
}