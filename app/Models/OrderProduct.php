<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'order_product';
    protected $primaryKey = 'id';

    public function Order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id', 'id');
    }

    public function Product()
    {
    	return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}
