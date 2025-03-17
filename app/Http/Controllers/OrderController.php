<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->latest()->get();
        return view('orders.index', compact('orders'));
    }
    
    public function store(Request $request)
    {
        $cart = Cart::where('user_id', auth()->id())->firstOrFail();
        
        $order = Order::create([
            'user_id' => auth()->id(),
            'total' => $cart->total,
            'status' => 'pending'
        ]);
        
        foreach ($cart->items as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price
            ]);
        }
        
        $cart->items()->delete();
        
        return redirect()->route('orders.show', $order);
    }
    
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }
    
    public function adminIndex()
    {
        $orders = Order::latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }
}