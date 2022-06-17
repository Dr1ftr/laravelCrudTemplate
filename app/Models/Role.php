<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // name of table
    public $table = 'role';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The users that have this role
     */
    public function users()
    {
        return $this->belongsToMany(User::class, "user-role", "role_id", "user_id")
            ->withTimestamps();
    }
}
