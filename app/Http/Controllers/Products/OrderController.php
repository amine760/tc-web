<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Auth::user()->orders()->with('items.product')->latest()->paginate(10);
        return view('orders.orders', compact('orders'));
    }

    public function cancel(Order $order)
    {
        // Verify the order belongs to the current user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Only allow cancellation if order is pending
        if ($order->status !== 'pending') {
            return back()->with('error', 'Order can only be cancelled if still pending');
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Order cancelled successfully');
    }


    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return view('orders.orders', compact('order'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        // Create the order
        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'total' => $this->calculateCartTotal($cart),
        ]);

        // Add all cart items as order items
        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['price'] * $item['quantity']
            ]);
        }
       // Clear the cart
        session()->forget('cart');

        return redirect()->route('home', $order)
            ->with('success', 'Order placed successfully!');
    }

    protected function calculateCartTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}
