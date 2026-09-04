@extends('layouts.app')

@section('title', 'Bill #'.str_pad($order->id, 5, '0', STR_PAD_LEFT).' - Poorti Cosmetic Center')

@section('content')
<div class="container" style="padding: 34px 0 70px; max-width:760px;">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;" class="no-print">
        <a href="{{ auth()->user()->isAdmin() ? route('admin.orders.index') : route('orders.index') }}" style="color:var(--plum); font-size:0.88rem;">&larr; Back to Orders</a>
        <button onclick="window.print()" class="btn btn-sm btn-outline">Print Bill</button>
    </div>

    <div class="card-panel" id="invoice">
        <div style="display:flex; justify-content:space-between; align-items:start; flex-wrap:wrap; gap:16px; border-bottom:1px solid #f1e6ec; padding-bottom:20px; margin-bottom:20px;">
            <div>
                <div class="display" style="font-size:1.5rem; color:var(--plum-dark); font-weight:700;">Poorti Cosmetic Center</div>
                <div style="font-size:0.85rem; color:#8a7580; margin-top:4px;">
                    Khanday Ray Ka Purwa, Binaur,<br>Sachendi, Kanpur Nagar
                </div>
            </div>
            <div style="text-align:right;">
                <div style="font-size:0.78rem; text-transform:uppercase; letter-spacing:0.08em; color:var(--gold); font-weight:600;">Bill No.</div>
                <div style="font-size:1.2rem; font-weight:700; color:var(--plum);">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
                <div style="font-size:0.82rem; color:#8a7580; margin-top:4px;">{{ $order->created_at->format('d M Y, h:i A') }}</div>
            </div>
        </div>

        <div style="display:flex; justify-content:space-between; flex-wrap:wrap; gap:16px; margin-bottom:24px;">
            <div>
                <div style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.08em; color:var(--gold); font-weight:600; margin-bottom:4px;">Billed To</div>
                <div style="font-weight:500;">{{ $order->user->name }}</div>
                <div style="font-size:0.85rem; color:#8a7580;">{{ $order->user->email }}</div>
                <div style="font-size:0.85rem; color:#8a7580;">{{ $order->user->phone ?? 'No phone on file' }}</div>
            </div>
            <div style="text-align:right;">
                <div style="font-size:0.75rem; text-transform:uppercase; letter-spacing:0.08em; color:var(--gold); font-weight:600; margin-bottom:4px;">Status</div>
                <span class="badge badge-{{ $order->status }}">{{ $order->statusLabel() }}</span>
            </div>
        </div>

        <table class="admin-table" style="margin-bottom:20px;">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Unit Price</th>
                    <th>Qty</th>
                    <th style="text-align:right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>₹{{ number_format($item->price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td style="text-align:right;">₹{{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="display:flex; justify-content:flex-end;">
            <div style="min-width:220px;">
                <div style="display:flex; justify-content:space-between; padding:6px 0; font-size:1.15rem;">
                    <span style="font-weight:600;">Grand Total</span>
                    <span style="font-weight:700; color:var(--plum);">₹{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <p style="text-align:center; color:#aaa; font-size:0.8rem; margin-top:30px;">Thank you for shopping with Poorti Cosmetic Center!</p>
    </div>

    @if(auth()->user()->isAdmin())
        <div class="card-panel no-print" style="margin-top:20px;">
            <div style="font-size:0.78rem; text-transform:uppercase; letter-spacing:0.08em; color:var(--gold); font-weight:600; margin-bottom:12px;">Admin: Order Workflow</div>

            <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:16px;">
                @if($order->nextStatus())
                    <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ $order->nextStatus() }}">
                        <button type="submit" class="btn btn-primary">{{ $order->nextActionLabel() }}</button>
                    </form>
                @endif

                @if(!in_array($order->status, ['delivered', 'cancelled']))
                    <form action="{{ route('admin.orders.status', $order) }}" method="POST" onsubmit="return confirm('Cancel this order?');">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="cancelled">
                        <button type="submit" class="btn btn-danger">Cancel Order</button>
                    </form>
                @endif

                <form action="{{ route('admin.orders.whatsapp', $order) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-gold">
                        {{ $order->whatsapp_sent_at ? 'Resend Invoice on WhatsApp' : 'Send Invoice on WhatsApp' }}
                    </button>
                </form>
            </div>

            @if($order->whatsapp_sent_at)
                <div style="font-size:0.82rem; color:#06895D;">✔ Invoice sent on WhatsApp — {{ $order->whatsapp_sent_at->format('d M Y, h:i A') }}</div>
            @else
                <div style="font-size:0.82rem; color:#8a7580;">Invoice has not been sent on WhatsApp yet.</div>
            @endif

            <div style="margin-top:16px; border-top:1px solid #f1e6ec; padding-top:14px;">
                <div style="font-size:0.75rem; color:#aaa; margin-bottom:8px;">Or set status manually:</div>
                <form action="{{ route('admin.orders.status', $order) }}" method="POST" style="display:flex; gap:10px;">
                    @csrf
                    @method('PATCH')
                    <select name="status" style="max-width:220px;">
                        <option value="pending" @selected($order->status=='pending')>Pending</option>
                        <option value="confirmed" @selected($order->status=='confirmed')>Confirmed</option>
                        <option value="packed" @selected($order->status=='packed')>Packed</option>
                        <option value="delivered" @selected($order->status=='delivered')>Delivered</option>
                        <option value="cancelled" @selected($order->status=='cancelled')>Cancelled</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-outline">Update</button>
                </form>
            </div>
        </div>
    @endif

</div>

<style>
    @media print {
        .navbar, footer, .topbar, .no-print { display: none !important; }
        body { background: #fff; }
    }
</style>
@endsection
