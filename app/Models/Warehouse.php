<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    // name of table
    public $table = 'warehouse';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'room',
    ];

    /**
     * The academy this warehouse is for
     */
    public function academy()
    {
        return $this->belongsTo(Academy::class);
    }

    /**
     * Where this warehouse is located
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * The articles in this warehouse
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
