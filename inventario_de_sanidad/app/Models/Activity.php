<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Activity extends Model
{
    use HasFactory;

    protected $primaryKey = 'activity_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'subject_id', 'description', 'activity_date'
    ];

    protected $casts = [
        'activity_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'subject_id');
    }

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class, 'activity_material', 'activity_id', 'material_id')
                    ->withPivot('quantity');
    }
}
