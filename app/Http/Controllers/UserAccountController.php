<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class UserAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['create', 'store']]);
    }

    public function index(Request $request) {
        $orders = $request->user()
                    ->cart
                    ->load('product', 'order')
                    ->where('is_fulfilled', 1)
                    ->sortByDesc('created_at')
                    ->groupBy(function($date) {
                        return Carbon::parse($date->updated_at)->format('F j, Y');
                    });
        // dd($orders);
        return inertia('Account/Index', [
            'orders' => $orders
        ]);
    }
    
    public function create() 
    {
        return inertia('Account/Create');
    }

    public function store(Request $request)
    {
        $user = User::create($request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]));

        Auth::login($user);

        event(new Registered($user));

        return redirect()->route('products.index')->with('success', 'Account created successfully.');
    }
}
