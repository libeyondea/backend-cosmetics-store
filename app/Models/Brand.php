<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brand';
    protected $primaryKey = 'id';

    public function Product()
    {
    	return $this->hasMany('App\Models\Product', 'brand_id', 'id');
    }

}
