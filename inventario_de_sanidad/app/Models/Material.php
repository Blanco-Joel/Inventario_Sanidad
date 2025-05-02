<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Material extends Model
{
    use HasFactory;

    protected $primaryKey = 'material_id';
    public $timestamps = false;

    protected $fillable = [
        'name', 'description', 'image_path'
    ];

    public function storage(): HasMany
    {
        return $this->hasMany(Storage::class, 'material_id', 'material_id');
    }

    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class, 'activity_material', 'material_id', 'activity_id')
                    ->withPivot('quantity');
    }
}
