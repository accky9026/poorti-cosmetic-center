@extends('layouts.app')

@section('title', 'All Orders - Poorti Cosmetic Center')

@section('content')
<div class="container" style="padding: 34px 0 70px;">

    <div style="display:flex; justify-content:space-between; align-items:end; flex-wrap:wrap; gap:16px; margin-bottom:26px;">
        <div>
            <div style="font-size:0.78rem; letter-spacing:0.14em; text-transform:uppercase; color:var(--gold); font-weight:600;">Admin Panel</div>
            <h1 class="display" style="font-size:2rem; color:var(--plum-dark); margin:4px 0 0;">Customer Orders &amp; Bills</h1>
        </div>
        <div class="card-panel" style="padding:14px 22px; text-align:center;">
            <div style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:var(--gold);">Total Revenue</div>
            <div style="font-size:1.4rem; font-weight:700; color:var(--plum);">₹{{ number_format($revenue, 2) }}</div>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.orders.index') }}" style="display:flex; gap:10px; margin-bottom:20px;">
        <select name="status" onchange="this.form.submit()">
            <option value="">All Statuses</option>
            <option value="pending" @selected(request('status')=='pending')>Pending</option>
            <option value="confirmed" @selected(request('status')=='confirmed')>Confirmed</option>
            <option value="packed" @selected(request('status')=='packed')>Packed</option>
            <option value="delivered" @selected(request('status')=='delivered')>Delivered</option>
            <option value="cancelled" @selected(request('status')=='cancelled')>Cancelled</option>
        </select>
        @if(request('status'))
            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm" style="color:#8a7580;">Clear</a>
        @endif
    </form>

    <div class="card-panel" style="padding:0; overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td style="font-weight:500;">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $order->user->name }}<br><span style="font-size:0.78rem; color:#aaa;">{{ $order->user->email }}</span></td>
                        <td>{{ $order->user->phone ?? '—' }}</td>
                        <td>{{ $order->created_at->format('d M Y, h:i A') }}</td>
                        <td style="font-weight:600; color:var(--plum);">₹{{ number_format($order->total_amount, 2) }}</td>
                        <td><span class="badge badge-{{ $order->status }}">{{ $order->statusLabel() }}</span></td>
                        <td style="text-align:right;">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline">View Bill</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:40px; color:#8a7580;">
                            No orders placed yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:24px;">
        {{ $orders->links() }}
    </div>

</div>
@endsection
