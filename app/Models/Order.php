<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Order extends Model
{
    use HasFactory;

    // name of table
    public $table = 'order';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name_product',
        'name',
        'total_amount',
        'price',
    ];

    // convert to and from float using eloquent mutators/accessor
    protected function price(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value /100),
            set: fn ($value) => floor($value *100)
        );
    }
}
