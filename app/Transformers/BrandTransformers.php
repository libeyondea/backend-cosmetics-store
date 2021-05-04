<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Brand;

class BrandTransformers extends TransformerAbstract
{
    public function transform(Brand $brand)
    {
        return [
            'id' => $brand->id,
            'title' => $brand->title,
            'slug' => $brand->slug,
            'content' => $brand->content,
            'created_at' => $brand->created_at,
            'updated_at' => $brand->updated_at
        ];
    }
}
