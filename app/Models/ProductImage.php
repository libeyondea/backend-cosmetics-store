<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_image';
    protected $primaryKey = 'id';

    public function Product()
    {
    	return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}
