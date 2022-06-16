<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vote extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'votes';

    protected $fillable = [
        'level',
        'comment',
        'name_user',
        'post_id', 'product_id', 'user_id',
    ];

    public function getUser(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function getPost(){
        return $this->belongsTo(Post::class,'post_id');
    }

    public function getProduct(){
        return $this->belongsTo(Products::class,'product_id');
    }
}
