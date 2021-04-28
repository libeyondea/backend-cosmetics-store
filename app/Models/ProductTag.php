<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
    protected $table = 'product_tag';
    protected $primaryKey = ['product_id', 'tag_id'];

    public function Product()
    {
    	return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function Tag()
    {
    	return $this->belongsTo('App\Models\Tag', 'tag_id', 'id');
    }
}
