<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryRelationship extends Model
{
    use HasFactory;
    protected $table = 'category_relationships';

    protected $fillable = [
        'cat_id',
        'post_id'
    ];

    public function getPosts(){
        return $this->hasMany(Post::class,'post_id');
    }

    public function getCategory(){
        return $this->belongsTo(Category::class,'cat_id');
    }
}
