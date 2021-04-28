<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tag';
    protected $primaryKey = 'id';

    public function ProductTag()
    {
    	return $this->hasMany('App\Models\ProductTag', 'tag_id', 'id');
    }

    public function Product()
    {
        return $this->belongsToMany('App\Models\Product', 'product_tag');
    }
}
