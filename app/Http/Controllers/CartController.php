<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    private function getCartId()
    {
        if (Auth::check()) {
            $cart = Auth::user()->cart ?? Cart::create(['user_id' => Auth::id()]);
            return $cart->id;
        }
        
        if (!Session::has('cart_id')) {
            $cart = Cart::create();
            Session::put('cart_id', $cart->id);
        }
        
        return Session::get('cart_id');
    }

    public function index()
    {
        $cartId = $this->getCartId();
        $cart = Cart::with('items.product')->findOrFail($cartId);
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($product->stock_quantity < $request->quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cartId = $this->getCartId();
        $cart = Cart::findOrFail($cartId);

        $cartItem = $cart->items()->where('product_id', $product->id)->first();
        
        if ($cartItem) {
            // Check if adding more quantity exceeds available stock
            if (($cartItem->quantity + $request->quantity) > $product->stock_quantity) {
                return back()->with('error', 'Cannot add more of this item - stock limit reached.');
            }
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
            ]);
        }

        // Update cart total
        $cart->updateTotal();

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Check stock availability
        if ($request->quantity > $cartItem->product->stock_quantity) {
            return back()->with('error', 'Requested quantity exceeds available stock.');
        }

        $cartItem->update(['quantity' => $request->quantity]);
        $cartItem->cart->updateTotal();

        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    public function remove(CartItem $cartItem)
    {
        $cart = $cartItem->cart;
        $cartItem->delete();
        $cart->updateTotal();

        return redirect()->route('cart.index')->with('success', 'Item removed.');
    }

    public function clear()
    {
        $cartId = $this->getCartId();
        $cart = Cart::findOrFail($cartId);
        $cart->items()->delete();
        $cart->updateTotal();

        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }

    // When user logs in, merge session cart with user cart
    public function mergeSessionCart()
    {
        if (!Session::has('cart_id') || !Auth::check()) {
            return;
        }

        $sessionCartId = Session::get('cart_id');
        $sessionCart = Cart::with('items')->find($sessionCartId);

        if (!$sessionCart) {
            return;
        }

        $userCart = Auth::user()->cart ?? Cart::create(['user_id' => Auth::id()]);

        foreach ($sessionCart->items as $item) {
            $existingItem = $userCart->items()->where('product_id', $item->product_id)->first();
            
            if ($existingItem) {
                $existingItem->quantity += $item->quantity;
                $existingItem->save();
            } else {
                $userCart->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);
            }
        }

        $sessionCart->items()->delete();
        $sessionCart->delete();
        Session::forget('cart_id');
        $userCart->updateTotal();
    }
}