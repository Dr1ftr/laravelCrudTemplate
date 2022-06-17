<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    // name of table
    public $table = 'loan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'article_id',
        'amount',

        'picked_up_at',
        'returned_at',

        'loaning_start',
        'loaning_end',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'picked_up_at' => 'datetime',
        'returned_at' => 'datetime',

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
