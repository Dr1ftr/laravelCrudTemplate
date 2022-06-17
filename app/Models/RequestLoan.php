<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestLoan extends Model
{
    use HasFactory;

    // name of table
    public $table = 'request_loan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'article_id',
        'amount',
        'loaning_start',
        'loaning_end',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'loaning_start' => 'datetime',
        'loaning_end' => 'datetime',
    ];

    /**
     * Who has made this request
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * What is being requested
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}


