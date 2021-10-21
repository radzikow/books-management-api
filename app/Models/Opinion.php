<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Opinion extends Model
{
    use HasApiTokens, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rating',
        'content',
        'author',
        'email',
        'book_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'rating' => 'int',
        'book_id' => 'int',
    ];

    /**
     * Get a  book that the opinion is about.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
