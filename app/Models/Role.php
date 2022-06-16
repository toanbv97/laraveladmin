<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'desc'];

    public function permissions(){
        return $this->belongsToMany(Permission::class, 'permission_roles', 'role_id', 'permission_id');
    }

    public function permission_role()
    {
        return $this->hasMany(Permission_role::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
