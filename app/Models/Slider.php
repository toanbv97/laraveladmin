<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $table = 'sliders';

    protected $fillable = [
        'name',
        'location',
        'link_target',
        'image', 'user_id','position','status'
    ];

    const IMAGE = 'no-images.jpg';
    const ACTIVE = 1;
    const DISABLE = 0;

    public static $arr_location = [
        1 => 'Banner',
        2 => 'SideBar',
        3 => 'Footer'
    ];

    public function getUser(){
        return $this->belongsTo(User::class,'user_id');
    }
}
