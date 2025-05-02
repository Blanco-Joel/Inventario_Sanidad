<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'first_name', 'last_name', 'email', 'hashed_password', 'role'
    ];

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class, 'user_id', 'user_id');
    }

    public function modifications(): HasMany
    {
        return $this->hasMany(Modification::class, 'user_id', 'user_id');
    }
}
