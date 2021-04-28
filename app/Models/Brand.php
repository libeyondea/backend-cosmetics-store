<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brand';
    protected $primaryKey = 'id';

    public function Post()
    {
    	return $this->hasMany('App\Models\Post', 'brand_id', 'id');
    }

}
