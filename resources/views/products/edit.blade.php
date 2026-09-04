@extends('layouts.app')

@section('title', 'Edit Product - Poorti Cosmetic Center')

@section('content')
<div class="container" style="padding: 34px 0 70px; max-width:760px;">

    <div style="margin-bottom:26px;">
        <div style="font-size:0.78rem; letter-spacing:0.14em; text-transform:uppercase; color:var(--gold); font-weight:600;">Admin Panel</div>
        <h1 class="display" style="font-size:2rem; color:var(--plum-dark); margin:4px 0 0;">Edit Product</h1>
    </div>

    <div class="card-panel">
        <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('products._form')

            <div style="display:flex; gap:12px; margin-top:10px;">
                <button type="submit" class="btn btn-primary">Update Product</button>
                <a href="{{ route('products.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>

</div>
@endsection
