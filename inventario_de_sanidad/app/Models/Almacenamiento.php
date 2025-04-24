<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacenamiento extends Model
{
    use HasFactory;
    protected $table = 'almacenamiento';
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = null;
    protected $fillable = [
        'id_material', 'tipo_almacen', 'armario', 'balda', 'unidades', 'min_unidades'
    ];
    public function material()
    {
        return $this->belongsTo(Material::class, 'id_material', 'id_material');
    }
}
