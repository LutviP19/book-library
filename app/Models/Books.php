<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author_id',
        'description',
    ];

    public function author()
    {
        return $this->belongsTo(BookAuthor::class, 'author_id', 'id');
    }
}
