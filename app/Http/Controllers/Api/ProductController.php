<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use League\Fractal\Resource\Collection;
use App\Models\Product;
use App\Transformers\ProductTransformers;

class ProductController extends Controller
{
    private $productTransformers;

    public function __construct(ProductTransformers $productTransformers)
    {
        $this->productTransformers = $productTransformers;
    }

    public function listProduct(Request $request, $limit = 10, $offset = 0, $field = 'created_at', $type = 'desc')
    {
        $limit = $request->input('limit', $limit);
        $offset = $request->input('offset', $offset);
        $field = $request->input('sort_field', $field);
        $type = $request->input('sort_type', $type);

        if ($request->filled('slug') && $request->filled('provider')) {
            $product = Product::whereHas($request->provider, function($q) use ($request) {
                $q->where('slug', $request->slug);
            });
            if ($request->filled('brands') && $request->brands) {
                $product = $product->whereHas('brand', function($q) use ($request) {
                    $q->whereIn('slug', $request->brands);
                });
                if ($request->filled('price_from') && $request->filled('price_to')) {
                    $product = $product->whereRaw('price-discount >= ? and price-discount <= ?', [$request->price_from, $request->price_to]);
                }
            } else if ($request->filled('price_from') && $request->filled('price_to')) {
                $product = $product->whereRaw('price-discount >= ? and price-discount <= ?', [$request->price_from, $request->price_to]);
            }
        } else {
            $product = new Product;
        }
        $productsCount = $product->get()->count();
        if ($field == 'price') {
            $listProduct = fractal($product->orderByRaw('(price - discount) '.$type)->skip($offset)->take($limit)->get(), $this->productTransformers);
        } else {
            $listProduct = fractal($product->orderBy($field, $type)->skip($offset)->take($limit)->get(), $this->productTransformers);
        }
        return response()->json([
            'success' => true,
            'data' => $listProduct,
            'meta' => [
                'products_count' => $productsCount
            ]
        ], 200);
    }

    public function singleProduct($slug)
    {
        $product = Product::where('slug', $slug);
        $singleProduct = fractal($product->first(), $this->productTransformers);
        return response()->json([
            'success' => true,
            'data' => $singleProduct
        ], 200);
    }
}
