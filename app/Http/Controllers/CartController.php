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
    private function getCart()
    {
        if (Auth::check()) {
            // For authenticated users, use database cart
            return Auth::user()->cart ?? Cart::create(['user_id' => Auth::id()]);
        }
        
        // For guests, use session cart
        if (!Session::has('cart')) {
            Session::put('cart', [
                'items' => [],
                'total' => 0
            ]);
        }
        
        return Session::get('cart');
    }

    public function index()
    {
        if (Auth::check()) {
            $cart = Cart::with('items.product')->where('user_id', Auth::id())->firstOrFail();
        } else {
            $cart = $this->getCart();
            // Load products for session cart items
            if (!empty($cart['items'])) {
                $productIds = array_column($cart['items'], 'product_id');
                $products = Product::whereIn('id', $productIds)->get();
                
                foreach ($cart['items'] as &$item) {
                    $item['product'] = $products->find($item['product_id']);
                }
            }
        }
        
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

        if (Auth::check()) {
            // Database cart for authenticated users
            $cart = $this->getCart();
            $cartItem = $cart->items()->where('product_id', $product->id)->first();
            
            if ($cartItem) {
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
            $cart->updateTotal();
        } else {
            // Session cart for guests
            $cart = $this->getCart();
            $found = false;
            
            foreach ($cart['items'] as &$item) {
                if ($item['product_id'] == $product->id) {
                    if (($item['quantity'] + $request->quantity) > $product->stock_quantity) {
                        return back()->with('error', 'Cannot add more of this item - stock limit reached.');
                    }
                    $item['quantity'] += $request->quantity;
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $cart['items'][] = [
                    'product_id' => $product->id,
                    'quantity' => $request->quantity,
                    'price' => $product->price
                ];
            }

            // Update cart total
            $cart['total'] = array_reduce($cart['items'], function($total, $item) {
                return $total + ($item['price'] * $item['quantity']);
            }, 0);

            Session::put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($productId);

        if ($request->quantity > $product->stock_quantity) {
            return back()->with('error', 'Requested quantity exceeds available stock.');
        }

        if (Auth::check()) {
            $cart = $this->getCart();
            $cartItem = $cart->items()->where('product_id', $productId)->firstOrFail();
            $cartItem->update(['quantity' => $request->quantity]);
            $cart->updateTotal();
        } else {
            $cart = $this->getCart();
            
            foreach ($cart['items'] as &$item) {
                if ($item['product_id'] == $productId) {
                    $item['quantity'] = $request->quantity;
                    break;
                }
            }

            // Update cart total
            $cart['total'] = array_reduce($cart['items'], function($total, $item) {
                return $total + ($item['price'] * $item['quantity']);
            }, 0);

            Session::put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    public function remove($productId)
    {
        if (Auth::check()) {
            $cart = $this->getCart();
            $cart->items()->where('product_id', $productId)->delete();
            $cart->updateTotal();
        } else {
            $cart = $this->getCart();
            
            $cart['items'] = array_filter($cart['items'], function($item) use ($productId) {
                return $item['product_id'] != $productId;
            });

            // Reindex array
            $cart['items'] = array_values($cart['items']);

            // Update cart total
            $cart['total'] = array_reduce($cart['items'], function($total, $item) {
                return $total + ($item['price'] * $item['quantity']);
            }, 0);

            Session::put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Item removed.');
    }

    public function clear()
    {
        if (Auth::check()) {
            $cart = $this->getCart();
            $cart->items()->delete();
            $cart->updateTotal();
        } else {
            Session::put('cart', [
                'items' => [],
                'total' => 0
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }

    // When user logs in, merge session cart into database cart
    public function mergeSessionCart()
    {
        if (!Session::has('cart') || !Auth::check()) {
            return;
        }

        $sessionCart = Session::get('cart');
        $userCart = Auth::user()->cart ?? Cart::create(['user_id' => Auth::id()]);

        foreach ($sessionCart['items'] as $item) {
            $existingItem = $userCart->items()->where('product_id', $item['product_id'])->first();
            
            if ($existingItem) {
                $existingItem->quantity += $item['quantity'];
                $existingItem->save();
            } else {
                $userCart->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
        }

        Session::forget('cart');
        $userCart->updateTotal();
    }
}