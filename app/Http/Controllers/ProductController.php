<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ProductImages;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $category = null)
    {
        $filters = [
            ...$request->only(['brand_id', 'category_id', 'price_from', 'price_to'])
        ];

        $products = Product::when($category, function($query, $value) {
                return $query->where('category_id', $this->getCategory($value));
        })->filterProducts($filters)
            ->with('images')  
            ->get();
        
        return inertia('Product/Index', [
            'brands' => Brand::all(),
            'categories' => $category ? null : Category::all(),
            'products' => $products,
            'imgPath' => config('misc.img_path')
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

        if ($request->images) {
            $request->validate([
                'media.*' => 'mimes:png,jpg,jpeg|max:5000'
            ],[
                'media.*.mimes' => "The file you're uploading should be one of the following formats: .jpg, .png or .jpeg."
            ]);

            $this->saveImages($request->images, $product);
        }

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
            'product' => $product->load('stocks', 'images'),
            'imgPath' => config('misc.img_path')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // dd($product->load('stocks', 'images'));
        return inertia('Product/Edit', [
            'product' => $product->load('stocks', 'images'),
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
        // foreach (json_decode(json_encode($request->images['removed']), false) as $image) {
        //     return $image->name;
        // }
        $product->update(
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

        // Check if images->added or images->removed are not empty, else continue
        if (!empty($request->images['added']) || !empty($request->images['removed'])) {
            if (!empty($request->images['added'])) {
                $this->saveImages($product, $request->images['added']);
            }

            if (!empty($request->images['removed'])) {
                $this->deleteImages($request->images['removed']);
            }
        }

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

    private function getCategory($category) {
        switch ($category) {
            case 'shoes':
                return 1;
                break;
            case 'accessories':
                return 2;
                break;
        }
    }

    private function saveImages($images, $product) {
        foreach ($images as $image) {
            $from = storage_path('app/public/tmp/uploads/' . $image);
            $to = storage_path('app/public/images/' . $image);

            File::move($from, $to);

            $product->images()->save(new ProductImages([
                'filename' => $image
            ]));
        }
    }

    private function deleteImages($images) {
        foreach (json_decode(json_encode($images), false) as $image) {
            // Find image from DB and delete
            ProductImages::find($image->id)->delete();

            // Delete image from directory
            File::delete(storage_path('app/public/images/' . $image->name));
        }
    }
}
