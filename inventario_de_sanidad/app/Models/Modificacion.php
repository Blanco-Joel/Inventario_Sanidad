<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modificacion extends Model
{
    use HasFactory;
    protected $table = 'modificaciones';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = null;
    protected $fillable = [
        'id_usuario', 'id_material', 'fecha_accion', 'accion', 'unidades', 'tipo_almacen',
    ];
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
    public function material()
    {
        return $this->belongsTo(Material::class, 'id_material', 'id_material');
    }
}
