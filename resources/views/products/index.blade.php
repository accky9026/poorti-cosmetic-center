@extends('layouts.app')

@section('title', 'Manage Products - Poorti Cosmetic Center')

@section('content')
<div class="container" style="padding: 34px 0 70px;">

    <div style="display:flex; justify-content:space-between; align-items:end; flex-wrap:wrap; gap:16px; margin-bottom:26px;">
        <div>
            <div style="font-size:0.78rem; letter-spacing:0.14em; text-transform:uppercase; color:var(--gold); font-weight:600;">Admin Panel</div>
            <h1 class="display" style="font-size:2rem; color:var(--plum-dark); margin:4px 0 0;">Manage Products</h1>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline">View Bills</a>
            <a href="{{ route('products.create') }}" class="btn btn-primary">+ Add New Product</a>
        </div>
    </div>

    <form method="GET" action="{{ route('products.index') }}" style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:20px;">
        <input type="text" name="search" placeholder="Search by name or brand..." value="{{ request('search') }}" style="max-width:260px;">
        <select name="category" onchange="this.form.submit()">
            <option value="">All Categories</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat }}" @selected(request('category')==$cat)>{{ $cat }}</option>
            @endforeach
        </select>
        <button class="btn btn-outline" type="submit">Filter</button>
        @if(request('search') || request('category'))
            <a href="{{ route('products.index') }}" class="btn btn-sm" style="color:#8a7580;">Clear</a>
        @endif
    </form>

    <div class="card-panel" style="padding:0; overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Featured</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td style="font-weight:500;">{{ $product->name }}</td>
                        <td><span class="badge badge-plum">{{ $product->category }}</span></td>
                        <td>{{ $product->brand ?? '—' }}</td>
                        <td>
                            ₹{{ number_format($product->final_price, 2) }}
                            @if($product->discount_price)
                                <div style="text-decoration:line-through; color:#aaa; font-size:0.78rem;">₹{{ number_format($product->price,2) }}</div>
                            @endif
                        </td>
                        <td>
                            @if($product->stock == 0)
                                <span class="badge badge-low">Out of stock</span>
                            @elseif($product->stock < 10)
                                <span class="badge badge-low">{{ $product->stock }} left</span>
                            @else
                                <span class="badge badge-ok">{{ $product->stock }} in stock</span>
                            @endif
                        </td>
                        <td>{{ $product->is_featured ? '★' : '—' }}</td>
                        <td style="text-align:right; white-space:nowrap;">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline">View</a>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-gold">Edit</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this product? This cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:40px; color:#8a7580;">
                            No products yet. Click "Add New Product" to create your first listing.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:24px;">
        {{ $products->links() }}
    </div>

</div>
@endsection
