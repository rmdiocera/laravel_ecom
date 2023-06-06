<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia('Product/Index', [
            'products' => Product::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Product/Create', [
            'categories' => Category::all(),
            'brands' => Brand::all(),
            'sizes' => Size::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = Product::create(
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'category_id' => 'required|not_in:0',
                'brand_id' => 'required|not_in:0',
                'price' => 'required|integer|min:1|max:1000000',
                'stocks.*.size' => 'required_if:category_id,1',
                'stocks.*.quantity' => 'required|not_in:0',
                // 'size' => 'required|not_in:0',
                // 'quantity' => 'required|integer|min:1|max:10000',
            ],
            [
                'category_id.not_in' => 'Please select a category.',
                'brand_id.not_in' => 'Please select a brand.',
                'stocks.*.size.required' => 'Please select a size.',
                'stocks.*.quantity.required' => 'Please provide stock quantity.',
                'stocks.*.quantity.not_in' => 'You have entered an invalid value.',
                // 'size.not_in' => 'Please select a size.'
            ])
        );

        foreach (json_decode(json_encode($request->stocks), false) as $stock) {
            $product->stocks()->create([
                'has_sizes' => $stock->size ? true : false,
                'size' => $stock->size ?? null,
                'quantity' => $stock->quantity
            ]);
        }

        return redirect()->route('products.index')->with('success', 'A new product has been added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return inertia('Product/Show', [
            'product' => $product->load('stocks')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // dd($product->load('stocks'));
        return inertia('Product/Edit', [
            'product' => $product->load('stocks'),
            'categories' => Category::all(),
            'brands' => Brand::all(),
            'sizes' => Size::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->update(
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'category_id' => 'required|not_in:0',
                'brand_id' => 'required|not_in:0',
                'price' => 'required|integer|min:1|max:1000000',
                'stocks.*.size' => 'required',
                'stocks.*.quantity' => 'required|not_in:0',
                // 'size' => 'required|not_in:0',
                // 'quantity' => 'required|integer|min:1|max:10000',
            ],
            [
                'category_id.not_in' => 'Please select a category.',
                'brand_id.not_in' => 'Please select a brand.',
                'stocks.*.size.required' => 'Please select a size.',
                'stocks.*.quantity.required' => 'Please provide stock quantity.',
                'stocks.*.quantity.not_in' => 'You have entered an invalid value.',
                // 'size.not_in' => 'Please select a size.'
            ])
        );

        foreach (json_decode(json_encode($request->stocks), false) as $stock) {
            $product->stocks()->updateOrCreate([
                'size' => $stock->size
            ],[
                'quantity' => $stock->quantity
            ]);
        }

        return redirect()->route('products.index')->with('success', 'The selected product has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // dd($product);
        $product->deleteOrFail();

        return redirect()->back()->with('success', 'Product deleted successfully.');
    }
}
