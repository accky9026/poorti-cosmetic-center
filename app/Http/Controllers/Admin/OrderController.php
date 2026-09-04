<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $orders = $query->paginate(15)->withQueryString();
        $revenue = Order::where('status', '!=', 'cancelled')->sum('total_amount');

        return view('admin.orders.index', compact('orders', 'revenue'));
    }

    public function show(Order $order)
    {
        $order->load('items', 'user');

        return view('orders.show', compact('order'));
    }

    /**
     * Move the order to the given status. Automatically sends the
     * WhatsApp invoice the moment an order becomes "delivered".
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,packed,delivered,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        $note = '';

        if ($request->status === 'delivered') {
            $sent = WhatsAppService::sendInvoice($order);
            $note = $sent
                ? ' Invoice sent to the customer on WhatsApp.'
                : ' (Could not send the WhatsApp invoice — check the customer\'s phone number and your Twilio settings.)';
        }

        return back()->with('success', 'Order #'.$order->id.' marked as '.$order->statusLabel().'.'.$note);
    }

    /**
     * Manually (re)send the WhatsApp invoice for an order, regardless of status.
     */
    public function sendWhatsapp(Order $order)
    {
        $sent = WhatsAppService::sendInvoice($order);

        return back()->with(
            $sent ? 'success' : 'error',
            $sent
                ? 'Invoice sent to the customer on WhatsApp.'
                : 'Could not send the WhatsApp invoice — check the customer\'s phone number and your Twilio settings in .env.'
        );
    }
}
