<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::query()->paginate();

        foreach ($products as &$product) {
            $product['images'] = $product->getAllImagesUrls();
        }

        return response()->json($products);
    }
}
