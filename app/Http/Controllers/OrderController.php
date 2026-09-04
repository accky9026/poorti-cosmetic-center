<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_unless(
            $order->user_id === Auth::id() || Auth::user()->isAdmin(),
            403
        );

        $order->load('items', 'user');

        return view('orders.show', compact('order'));
    }
}
