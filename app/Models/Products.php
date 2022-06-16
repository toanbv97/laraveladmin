<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'slug',
        'price',
        'quantity',
        'content',
        'thumb',
        'image',
        'status',
        'user_id'
    ];
    const IMAGE = 'no-images.jpg';
    const ACTIVE = 1;
    const DISABLE = 0;

    // public function getUser(){
    //     return $this->belongsTo(User::class,'user_id');
    // }

    // public function getVotes(){
    //     return $this->hasMany(Vote::class,'post_id');
    // }

    public function order_item(){
        return $this->hasMany(Order_item::class);
    }
}
