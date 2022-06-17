<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academy extends Model
{
    use HasFactory;

    // name of table
    public $table = 'academy';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'crebo_number',
    ];

    /**
     * The warehouses that belong to this academy
     */
    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }

    /**
     * The users that are part of this academy
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
