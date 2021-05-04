<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Transformers\BrandTransformers;

class BrandController extends Controller
{
    private $brandTransformers;

    public function __construct(BrandTransformers $brandTransformers)
    {
        $this->brandTransformers = $brandTransformers;
    }

    public function listBrand(Request $request, $limit = 20, $offset = 0)
    {
        $limit = $request->get('limit', $limit);
        $offset = $request->get('offset', $offset);

        $brand = Brand::orderBy('created_at', 'desc');
        $listBrand = fractal($brand->skip($offset)->take($limit)->get(), $this->brandTransformers);
        $brandsCount = $brand->get()->count();
        return response()->json([
            'success' => true,
            'data' => $listBrand,
            'meta' => [
                'brands_count' => $brandsCount
            ]
        ], 200);
    }
}
