<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request) {
        // Create order
        $order = $request->user()->orders()->create([
            'amount' => $request->amount
        ]);

        // Tag customer's item(s) in cart as fulfilled
        foreach($request->cart as $item) {
            $item = Cart::where('id', $item['id'])
                        ->update([
                            'is_fulfilled' => true,
                            'order_id' => $order->id
                        ]);
        }

        return redirect()->route('products.index')->with('success', 'Your order has been processed successfully. Please check your email for updates regarding with your purchase.');
    }
}
