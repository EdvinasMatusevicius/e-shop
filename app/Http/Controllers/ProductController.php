<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Class ProductController
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $products = Product::query()->paginate();

        return view('products.list', ['list' => $products]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('products.form');
    }

    /**
     * @param ProductStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ProductStoreRequest $request): RedirectResponse
    {
        Product::query()->create($request->getData());

        return redirect()->route('products.index')
            ->with('status', 'Created.');
    }
}