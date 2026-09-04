<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function store()
    {
        $items = CartService::items();

        if (empty($items)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $order = DB::transaction(function () use ($items) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => CartService::total($items),
                'status' => 'pending',
            ]);

            foreach ($items as $row) {
                /** @var \App\Models\Product $product */
                $product = $row['product'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->final_price,
                    'quantity' => $row['quantity'],
                    'subtotal' => $row['subtotal'],
                ]);

                if ($product->stock >= $row['quantity']) {
                    $product->decrement('stock', $row['quantity']);
                }
            }

            return $order;
        });

        CartService::clear();

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order placed successfully! Here is your bill.');
    }
}
