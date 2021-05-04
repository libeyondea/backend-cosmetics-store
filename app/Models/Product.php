<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'id';

    public function User()
    {
    	return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function PostTag()
    {
    	return $this->hasMany('App\Models\PostTag', 'product_id', 'id');
    }

    public function Tag()
    {
        return $this->belongsToMany('App\Models\Tag', 'product_tag');
    }

    public function Category()
    {
    	return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    public function Brand()
    {
    	return $this->belongsTo('App\Models\Brand', 'brand_id', 'id');
    }

    public function Comment()
    {
    	return $this->hasMany('App\Models\Comment', 'product_id', 'id');
    }

    public function ProductImage()
    {
    	return $this->hasMany('App\Models\ProductImage', 'product_id', 'id');
    }

    public function OrderProduct()
    {
    	return $this->hasMany('App\Models\OrderProduct', 'product_id', 'id');
    }

    public function CartProduct()
    {
    	return $this->hasMany('App\Models\CartProduct', 'product_id', 'id');
    }

    public function Cart()
    {
        return $this->belongsToMany('App\Models\Cart', 'cart_product');
    }
}
