<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $table = 'activities';
    public $timestamps = false;
    protected $primaryKey = 'activity_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $casts = [
        'created_at' => 'datetime',
    ];
    protected $fillable = [
        'user_id', 'description', 'created_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'material_activity', 'activity_id', 'material_id')
                    ->withPivot('quantity');
    }
}
