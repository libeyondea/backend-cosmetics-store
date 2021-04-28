<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Tag;
use App\Models\ProductImage;

class ProductTransformers extends TransformerAbstract
{
    protected $defaultIncludes = [
        'brand', 'category', 'tags', 'images'
    ];

    public function transform(Product $product)
    {
        return [
            'id' => $product->id,
            'title' => $product->title,
            'slug' => $product->slug,
            'excerpt' => $product->excerpt,
            'content' => $product->content,
            'price' => $product->price,
            'discount' => $product->discount,
            'quantity' => $product->quantity,
            'published' => $product->published,
            'published_at' => $product->published_at,
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
            'total_comments' =>$product->comment->count(),
        ];
    }

    public function includeBrand(Product $product)
    {
        $brand = $product->brand;
        return $this->item($brand, function(Brand $brand) {
            return [
                'id' => $brand->id,
                'title' => $brand->title,
                'slug' => $brand->slug
            ];
        });
    }

    public function includeCategory(Product $product)
    {
        $category = $product->category;
        return $this->item($category, function(Category $category) {
            return [
                'id' => $category->id,
                'title' => $category->title,
                'slug' => $category->slug
            ];
        });
    }

    public function includeTags(Product $product)
    {
        $tag = $product->tag;
        return $this->collection($tag, function(Tag $tag) {
            return [
                'id' => $tag->id,
                'title' => $tag->title,
                'slug' => $tag->slug
            ];
        });
    }

    public function includeImages(Product $product)
    {
        $productimage = $product->productimage;
        return $this->collection($productimage, function(ProductImage $productimage) {
            return [
                'id' => $productimage->id,
                'title' => $productimage->title,
                'image_url' => $productimage->image_url
            ];
        });
    }
}
