<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $table = 'materiales';
    public $timestamps = false;
    protected $primaryKey = 'id_material';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id_material', 'nombre', 'descripcion'
    ];
    public function almacenamiento()
    {
        return $this->hasMany(Almacenamiento::class, 'id_material', 'id_material');
    }

    public function modificaciones()
    {
        return $this->hasMany(Modificacion::class, 'id_material', 'id_material');
    }
}
