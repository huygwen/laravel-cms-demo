<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reader extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'viewed'
    ];

    public function post()
    {
        $this->belongsTo(Post::class, 'post_id');
    }

    public function user()
    {
        $this->belongsTo(User::class, 'user_id');
    }
}
