<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id()
        ]);
        
        return view('cart.index', compact('cart'));
    }
    
    public function add(Request $request, Product $product)
    {
        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id()
        ]);
        
        $cartItem = $cart->items()->updateOrCreate(
            ['product_id' => $product->id],
            ['quantity' => $request->quantity ?? 1]
        );
        
        return redirect()->back()->with('success', 'Product added to cart');
    }
    
    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);
        $cartItem->update(['quantity' => $request->quantity]);
        
        return redirect()->back()->with('success', 'Cart updated');
    }
    
    public function remove(CartItem $cartItem)
    {
        $cartItem->delete();
        return redirect()->back()->with('success', 'Item removed from cart');
    }
}