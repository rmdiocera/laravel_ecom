<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index() {
        $favorites = Auth::user()->favorites->load('product');
        return inertia('Favorite/Index', [
            'favorites' => $favorites
        ]);
    }

    public function store($product_id, $size = null)
    {
        // dd($product_id, $size);
        // Add selected product to user's favorites
        Favorite::create([
            'product_id' => $product_id,
            'user_id' => Auth::user()->id,
            'size' => $size
        ]);

        return back()->with('success', 'This item has been added to your favorites.');
    }
}
