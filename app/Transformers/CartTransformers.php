<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Cart;

class CartTransformers extends TransformerAbstract
{
    public function transform(Cart $cart)
    {
        return [
            'id' => $cart->id,
            'user_id' => $cart->user_id,
            'created_at' => $cart->created_at,
            'updated_at' => $cart->updated_at
        ];
    }
}
