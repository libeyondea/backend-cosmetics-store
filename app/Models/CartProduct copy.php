<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    protected $table = 'cart_product';
    protected $primaryKey = 'id';

    public function Cart()
    {
        return $this->belongsTo('App\Models\Cart', 'cart_id', 'id');
    }

    public function Product()
    {
    	return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}
