<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    // name of table
    public $table = 'location';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',

        'country',
        'city',
        'street',
        'street_number',
        'street_number_addition',

        'postal_code',
    ];

    /**
     * The warehouses at this location
     */
    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }
}
