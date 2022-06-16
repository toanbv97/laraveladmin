<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'id',
        'name',
        'slug',
        'taxonomy',
        'parent_id',
        'user_id',
        'status',
    ];

    const BAI_VIET = 0;

    public static function recursive($data, $parents = 0, $level = 1, &$listcategory)
    {
        if (count($data)>0) {
            foreach ($data as $key => $value) {
                // code...
                if ($value->parent_id==$parents) {
                    // code...
                    $value->level=$level;
                    $listcategory[]=$value;
                    unset($data[$key]);
                    $parent = $value->id;
                    self::recursive($data, $parent, $level + 1, $listcategory);

                }
            }
        }

    }

}
