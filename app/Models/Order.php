<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $primaryKey = 'id';

    public function User()
    {
    	return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function OrderProduct()
    {
    	return $this->hasMany('App\Models\OrderProduct', 'order_id', 'id');
    }
}
