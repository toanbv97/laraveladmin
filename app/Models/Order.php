<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['customer_id', 'customer_name', 'email', 'address', 'phone_number', 'note', 'payment_method', 'total', 'status'];

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function products(){
        return $this->belongsToMany(Products::class, 'order_items', 'order_id', 'product_id');
    }

    public function order_item(){
        return $this->hasMany(Order_item::class);
    }
}
