<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Modification extends Model
{
    use HasFactory;

    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'material_id', 'storage_type', 'timestamp', 'quantity'
    ];

    protected $casts = [
        'timestamp' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function storage(): BelongsTo
    {
        return $this->belongsTo(Storage::class, 'material_id', 'material_id')
                    ->where('storage_type', $this->storage_type);
    }
}
