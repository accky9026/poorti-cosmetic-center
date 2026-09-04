@extends('layouts.app')

@section('title', $product->name . ' - Poorti Cosmetic Center')

@section('content')
<div class="container" style="padding: 34px 0 70px;">

    <a href="{{ route('products.index') }}" style="color:var(--plum); font-size:0.88rem;">&larr; Back to Manage Products</a>

    <div class="card-panel" style="margin-top:20px; display:flex; gap:34px; flex-wrap:wrap;">
        <div style="flex:0 0 260px;">
            <div style="width:100%; height:260px; border-radius:12px; background: linear-gradient(135deg, var(--blush), #fff); display:flex; align-items:center; justify-content:center; overflow:hidden;">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" style="width:100%; height:100%; object-fit:cover;">
                @else
                    <span style="font-family:'Cormorant Garamond',serif; font-size:1.6rem; color:var(--gold);">Poorti</span>
                @endif
            </div>
        </div>
        <div style="flex:1; min-width:260px;">
            <div style="font-size:0.78rem; text-transform:uppercase; letter-spacing:0.1em; color:var(--gold); font-weight:600;">
                {{ $product->category }} @if($product->brand) · {{ $product->brand }} @endif
            </div>
            <h1 class="display" style="font-size:2rem; color:var(--plum-dark); margin:6px 0 14px;">{{ $product->name }}</h1>

            <div style="margin-bottom:16px;">
                <span style="font-size:1.4rem; font-weight:600; color:var(--plum);">₹{{ number_format($product->final_price, 2) }}</span>
                @if($product->discount_price)
                    <span style="text-decoration:line-through; color:#aaa; margin-left:8px;">₹{{ number_format($product->price,2) }}</span>
                    <span class="badge badge-ok" style="margin-left:8px;">{{ $product->discount_percent }}% OFF</span>
                @endif
            </div>

            <p style="color:#5a4a52; line-height:1.7; max-width:520px;">{{ $product->description ?: 'No description added yet.' }}</p>

            <div style="margin:18px 0;">
                @if($product->stock == 0)
                    <span class="badge badge-low">Out of stock</span>
                @else
                    <span class="badge badge-ok">{{ $product->stock }} units in stock</span>
                @endif
                @if($product->is_featured)
                    <span class="badge badge-plum">★ Store Favourite</span>
                @endif
            </div>

            <div style="display:flex; gap:12px;">
                <a href="{{ route('products.edit', $product) }}" class="btn btn-gold">Edit Product</a>
                <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product? This cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Product</button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
