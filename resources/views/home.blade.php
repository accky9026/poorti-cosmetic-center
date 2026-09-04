@extends('layouts.app')

@section('title', 'Poorti Cosmetic Center - Beauty, Skin & Glow')

@section('content')

    {{-- HERO --}}
    <section style="background: linear-gradient(135deg, var(--blush) 0%, #fff 60%); padding: 64px 0 0;">
        <div class="container" style="display:flex; align-items:center; gap:50px; flex-wrap:wrap;">
            <div style="flex:1; min-width:280px;">
                <div style="font-size:0.78rem; letter-spacing:0.18em; text-transform:uppercase; color:var(--gold); font-weight:600; margin-bottom:14px;">
                    Sachendi · Kanpur Nagar
                </div>
                <h1 class="display" style="font-size:3.2rem; line-height:1.08; color:var(--plum-dark); margin:0 0 18px;">
                    Everyday Beauty,<br>Honestly Priced.
                </h1>
                <p style="font-size:1.05rem; color:#5a4a52; max-width:460px; margin-bottom:28px;">
                    From daily skincare to festival-ready makeup — Poorti Cosmetic Center brings you trusted brands at prices your whole family will love.
                </p>
                <div style="display:flex; gap:14px;">
                    <a href="#shop" class="btn btn-primary">Browse Products</a>
                    <a href="{{ route('products.index') }}" class="btn btn-outline">Manage Shop</a>
                </div>
            </div>
            <div style="flex:1; min-width:280px; display:flex; justify-content:center;">
                <div style="width:320px; height:320px; border-radius:50%; background: radial-gradient(circle at 32% 28%, #fff 0%, var(--gold-soft) 40%, var(--plum) 100%); display:flex; align-items:center; justify-content:center; box-shadow: 0 30px 60px -20px rgba(92,33,64,0.35);">
                    <div style="width:220px; height:220px; border-radius:50%; background:#fff; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center;">
                        <div class="display" style="font-size:2.4rem; color:var(--plum); font-weight:700;">{{ $products->total() }}+</div>
                        <div style="font-size:0.78rem; letter-spacing:0.1em; text-transform:uppercase; color:var(--gold);">Products In Store</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="scallop" style="margin-top:50px;"></div>
    </section>

    {{-- FEATURED --}}
    @if ($featured->count())
    <section style="padding: 10px 0 50px;">
        <div class="container">
            <h2 class="display" style="font-size:1.8rem; color:var(--plum-dark); margin-bottom:22px;">Store Favourites</h2>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px,1fr)); gap:22px;">
                @foreach ($featured as $item)
                    <div class="card-panel" style="padding:0; overflow:hidden;">
                        <div style="height:150px; background: linear-gradient(135deg, var(--blush), #fff); display:flex; align-items:center; justify-content:center;">
                            @if($item->image)
                                <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->name }}" style="width:100%; height:100%; object-fit:cover;">
                            @else
                                <span style="font-family:'Cormorant Garamond',serif; font-size:1.4rem; color:var(--gold);">Poorti</span>
                            @endif
                        </div>
                        <div style="padding:16px;">
                            <div style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.08em; color:var(--gold); margin-bottom:4px;">{{ $item->category }}</div>
                            <div style="font-weight:500; margin-bottom:8px;">{{ $item->name }}</div>
                            <div>
                                <span style="font-weight:600; color:var(--plum);">₹{{ number_format($item->final_price, 2) }}</span>
                                @if($item->discount_price)
                                    <span style="text-decoration:line-through; color:#aaa; font-size:0.82rem; margin-left:6px;">₹{{ number_format($item->price,2) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- FULL CATALOGUE --}}
    <section id="shop" style="background:var(--blush); padding:50px 0;">
        <div class="container">
            <div style="display:flex; justify-content:space-between; align-items:end; flex-wrap:wrap; gap:16px; margin-bottom:24px;">
                <h2 class="display" style="font-size:1.8rem; color:var(--plum-dark); margin:0;">Shop All Products</h2>

                <form method="GET" action="{{ route('home') }}#shop" style="display:flex; gap:10px; flex-wrap:wrap;">
                    <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}" style="min-width:200px;">
                    <select name="category" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" @selected(request('category')==$cat)>{{ $cat }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-gold" type="submit">Search</button>
                </form>
            </div>

            @if ($products->count() === 0)
                <div class="card-panel" style="text-align:center; padding:50px;">
                    <p style="margin:0; color:#8a7580;">No products match your search yet. Try a different keyword or category.</p>
                </div>
            @else
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(230px,1fr)); gap:22px;">
                    @foreach ($products as $product)
                        <div class="card-panel" style="padding:0; overflow:hidden;">
                            <div style="height:160px; background:#fff; display:flex; align-items:center; justify-content:center;">
                                @if($product->image)
                                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" style="width:100%; height:100%; object-fit:cover;">
                                @else
                                    <span style="font-family:'Cormorant Garamond',serif; font-size:1.4rem; color:var(--gold);">Poorti</span>
                                @endif
                            </div>
                            <div style="padding:16px;">
                                <div style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.08em; color:var(--gold); margin-bottom:4px;">
                                    {{ $product->category }} @if($product->brand) · {{ $product->brand }} @endif
                                </div>
                                <div style="font-weight:500; margin-bottom:8px; min-height:44px;">{{ $product->name }}</div>
                                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                                    <div>
                                        <span style="font-weight:600; color:var(--plum);">₹{{ number_format($product->final_price, 2) }}</span>
                                        @if($product->discount_price)
                                            <span style="text-decoration:line-through; color:#aaa; font-size:0.8rem; margin-left:4px;">₹{{ number_format($product->price,2) }}</span>
                                        @endif
                                    </div>
                                    @if($product->stock > 0)
                                        <span class="badge badge-ok">In Stock</span>
                                    @else
                                        <span class="badge badge-low">Sold Out</span>
                                    @endif
                                </div>

                                @auth
                                    @if(!auth()->user()->isAdmin())
                                        @if($product->stock > 0)
                                            <form action="{{ route('cart.add', $product) }}" method="POST" style="display:flex; gap:6px;">
                                                @csrf
                                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" style="width:60px; padding:8px;">
                                                <button type="submit" class="btn btn-sm btn-primary" style="flex:1;">Add to Cart</button>
                                            </form>
                                        @else
                                            <button class="btn btn-sm" style="width:100%; background:#eee; color:#999;" disabled>Out of Stock</button>
                                        @endif
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline" style="display:block; text-align:center;">Login to Buy</a>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>

                <div style="margin-top:30px;">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </section>

    <section id="about" style="padding:60px 0;">
        <div class="container" style="max-width:760px; text-align:center;">
            <h2 class="display" style="font-size:1.8rem; color:var(--plum-dark);">About Poorti Cosmetic Center</h2>
            <p style="color:#5a4a52; line-height:1.8;">
                Located in Khanday Ray Ka Purwa, Binaur, Sachendi, Kanpur Nagar, Poorti Cosmetic Center has been serving the local community with genuine skincare, makeup, haircare and fragrance products at honest prices. We believe good beauty care should be simple, affordable, and trustworthy.
            </p>
        </div>
    </section>

@endsection
