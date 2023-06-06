<?php

namespace App\Http\Controllers;

use Closure;
use App\Models\Cart;
use App\Models\Stock;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request) {
        // Replace where function with scope
        $cart = Auth::user()->cart->load('product', 'stock')->where('is_fulfilled', 0);

        $total = $cart->isNotEmpty()
                ? $cart->reduce(function ($carry, mixed $item) {
                return $carry + ($item->product->price * $item->quantity);
                })
                : null;

        $payLink = $cart->isNotEmpty() 
                    ? Auth::user()->charge($total, 'Cart', [
                        'quantity_variable' => 0
                    ])
                    : null;

        return inertia('Cart/Index', [
            'cart' => $cart,
            'total' => $total,
            'payLink' => $payLink
        ]);
    }

    public function store(Product $product, Request $request)
    {
        // Validate if there's stocks left
        $request->validate([
            'size' => 'required_if:has_sizes,true'
        ],[
            'size.required_if' => "Please select a size."
        ]);

        // Reduce stock quantity
        $stock = Stock::where('product_id', $product->id)
            ->when($request->has('size'), function($query) use ($request) {
                return $query->where('size', $request->size);
            })->first();
        
        if ($stock->quantity == 0) {
            return back()->withErrors(['size' => 'The size you have chosen is currently unavailable.']);    
        } else {
            $stock->decrement('quantity');
        }
        
        // Add product to customer's cart if first instance or update quantity if existing
        Cart::updateOrCreate([
            'product_id' => $product->id,
            'stock_id' => $stock->id,
            'user_id' => $request->user()->id,
            'is_fulfilled' => 0,
            'order_id' => null
        ],[
            'size' => $request->size ?? null,
            'has_sizes' => $request->size ?? false,
        ])->increment('quantity');


        return back()->with('success', 'This has been added to your cart.');
    }

    public function update(Cart $cart, Stock $stock, Request $request) {
        // Validate if there's stocks left
        $request->validate([
            'difference' => function (string $attribute, mixed $value, Closure $fail) use ($request, $stock) {
                // If it's a change to add quantity in customer's cart, check if quantity to be added is greater than remaining stock; if yes, cancel change
                if (($request->change == 'add' && $value > $stock->quantity)) {
                    $fail("An unexpected error has occured.");
                }
            }
        ]);
        
        // Check if change in quantity is to add or reduce
        if ($request->change == "add") {
            $cart->increment('quantity', $request->difference);
            $stock->decrement('quantity', $request->difference);
        } else {
            $cart->decrement('quantity', $request->difference);
            $stock->increment('quantity', $request->difference);
        }

        return back();
    }

    public function destroy(Cart $cart)
    {
        // Restore stock quantity from cart
        $cart->stock()->increment('quantity', $cart->quantity);

        $cart->deleteOrFail();

        return redirect()->back()->with('success', 'Item has been removed from your cart.');
    }

}
