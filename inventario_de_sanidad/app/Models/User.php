<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $table = 'users';
    public $timestamps = false;
    protected $primaryKey = 'user_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $casts = [
        'created_at' => 'datetime',
    ];
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'hashed_password',
        'user_type',
        'first_log',
        'created_at'
    ];

    public function modifications()
    {
        return $this->hasMany(Modification::class, 'user_id', 'user_id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'user_id', 'user_id');
    }
}
