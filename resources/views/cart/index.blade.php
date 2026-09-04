@extends('layouts.app')

@section('title', 'Your Cart - Poorti Cosmetic Center')

@section('content')
<div class="container" style="padding: 34px 0 70px;">

    <div style="margin-bottom:26px;">
        <div style="font-size:0.78rem; letter-spacing:0.14em; text-transform:uppercase; color:var(--gold); font-weight:600;">Step 1 of 2</div>
        <h1 class="display" style="font-size:2rem; color:var(--plum-dark); margin:4px 0 0;">Your Cart</h1>
    </div>

    @if (empty($items))
        <div class="card-panel" style="text-align:center; padding:60px;">
            <p style="color:#8a7580; margin-bottom:18px;">Your cart is empty.</p>
            <a href="{{ route('home') }}#shop" class="btn btn-primary">Continue Shopping</a>
        </div>
    @else
        <div class="card-panel" style="padding:0; overflow-x:auto;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $row)
                        <tr>
                            <td style="font-weight:500;">{{ $row['product']->name }}</td>
                            <td>₹{{ number_format($row['product']->final_price, 2) }}</td>
                            <td>
                                <form action="{{ route('cart.update', $row['product']) }}" method="POST" style="display:flex; gap:6px; align-items:center;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $row['quantity'] }}" min="1" max="{{ $row['product']->stock }}" style="width:64px; padding:6px;">
                                    <button type="submit" class="btn btn-sm btn-outline">Update</button>
                                </form>
                            </td>
                            <td style="font-weight:600; color:var(--plum);">₹{{ number_format($row['subtotal'], 2) }}</td>
                            <td>
                                <form action="{{ route('cart.remove', $row['product']) }}" method="POST" onsubmit="return confirm('Remove this item from your cart?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="display:flex; justify-content:flex-end; margin-top:24px;">
            <div class="card-panel" style="min-width:280px;">
                <div style="display:flex; justify-content:space-between; font-size:1.1rem; margin-bottom:18px;">
                    <span style="font-weight:500;">Total</span>
                    <span style="font-weight:700; color:var(--plum);">₹{{ number_format($total, 2) }}</span>
                </div>
                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="width:100%;">Place Order &amp; Generate Bill</button>
                </form>
                <a href="{{ route('home') }}#shop" class="btn btn-outline" style="width:100%; text-align:center; margin-top:10px; display:block;">Continue Shopping</a>
            </div>
        </div>
    @endif

</div>
@endsection
