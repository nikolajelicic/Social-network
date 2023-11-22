<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment_like extends Model
{
    use HasFactory;

    protected $fillable = ['comment_id', 'user_id', 'created_at'];

    public function comment(){
        return $this->belongsTo(Comment::class, 'comment_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'user_id');
    }
}
