@extends('layouts.app')

@section('title', 'My Orders - Poorti Cosmetic Center')

@section('content')
<div class="container" style="padding: 34px 0 70px;">

    <div style="margin-bottom:26px;">
        <div style="font-size:0.78rem; letter-spacing:0.14em; text-transform:uppercase; color:var(--gold); font-weight:600;">Your Account</div>
        <h1 class="display" style="font-size:2rem; color:var(--plum-dark); margin:4px 0 0;">My Orders</h1>
    </div>

    @if ($orders->count() === 0)
        <div class="card-panel" style="text-align:center; padding:60px;">
            <p style="color:#8a7580; margin-bottom:18px;">You haven't placed any orders yet.</p>
            <a href="{{ route('home') }}#shop" class="btn btn-primary">Start Shopping</a>
        </div>
    @else
        <div class="card-panel" style="padding:0; overflow-x:auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td style="font-weight:500;">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                            <td style="font-weight:600; color:var(--plum);">₹{{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                <span class="badge badge-{{ $order->status }}">{{ $order->statusLabel() }}</span>
                            </td>
                            <td><a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline">View Bill</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top:24px;">
            {{ $orders->links() }}
        </div>
    @endif

</div>
@endsection
