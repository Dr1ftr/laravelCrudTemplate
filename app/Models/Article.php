<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    // name of table
    public $table = 'article';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'total_amount',
        'price',
    ];

    /**
     * The loan request containing this article
     */
    public function requestLoan()
    {
        return $this->belongsToMany(RequestLoan::class, "requestloan-article", "article_id", "request_loan_id")
            ->withTimestamps();
    }

    // convert to and from float using eloquent mutators/accessor
    protected function price(): Attribute
    {
        return new Attribute(
            get: fn ($value) => ($value /100),
            set: fn ($value) => floor($value *100)
        );
    }


    /**
     * The warehouses where this article is located
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
