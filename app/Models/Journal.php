<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'abstract',
        'datePublished',
        'filePath',
        'user_id', // Assuming user_id is fillable
        'publisher',
        'fileName',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
