<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    protected $table = 'usuarios';
    public $timestamps = false;
    protected $primaryKey = 'id_usuario';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $casts = [
        'fecha_alta' => 'date',
    ];
    protected $fillable = [
        'id_usuario', 'nombre', 'apellidos', 'fecha_alta', 'tipo_usuario',
    ];
    public function modificaciones()
    {
        return $this->hasMany(Modificacion::class, 'id_usuario', 'id_usuario');
    }
}
