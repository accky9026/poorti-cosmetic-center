@csrf

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
    <div class="form-control-wrap">
        <label class="field-label">Product Name *</label>
        <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" placeholder="e.g. Radiant Glow Face Cream">
        @error('name') <div class="error-text">{{ $message }}</div> @enderror
    </div>

    <div class="form-control-wrap">
        <label class="field-label">Category *</label>
        <input type="text" name="category" value="{{ old('category', $product->category ?? '') }}" placeholder="e.g. Skincare, Makeup, Haircare">
        @error('category') <div class="error-text">{{ $message }}</div> @enderror
    </div>

    <div class="form-control-wrap">
        <label class="field-label">Brand</label>
        <input type="text" name="brand" value="{{ old('brand', $product->brand ?? '') }}" placeholder="e.g. Lakme">
        @error('brand') <div class="error-text">{{ $message }}</div> @enderror
    </div>

    <div class="form-control-wrap">
        <label class="field-label">Stock Quantity *</label>
        <input type="number" name="stock" min="0" value="{{ old('stock', $product->stock ?? 0) }}">
        @error('stock') <div class="error-text">{{ $message }}</div> @enderror
    </div>

    <div class="form-control-wrap">
        <label class="field-label">Price (₹) *</label>
        <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $product->price ?? '') }}">
        @error('price') <div class="error-text">{{ $message }}</div> @enderror
    </div>

    <div class="form-control-wrap">
        <label class="field-label">Discount Price (₹)</label>
        <input type="number" step="0.01" min="0" name="discount_price" value="{{ old('discount_price', $product->discount_price ?? '') }}" placeholder="Optional">
        @error('discount_price') <div class="error-text">{{ $message }}</div> @enderror
    </div>
</div>

<div class="form-control-wrap">
    <label class="field-label">Description</label>
    <textarea name="description" rows="4" placeholder="Short description shown to customers...">{{ old('description', $product->description ?? '') }}</textarea>
    @error('description') <div class="error-text">{{ $message }}</div> @enderror
</div>

<div class="form-control-wrap">
    <label class="field-label">Product Image</label>
    <input type="file" name="image" accept="image/*">
    @if(!empty($product) && $product->image)
        <div style="margin-top:10px;">
            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" style="width:90px; height:90px; object-fit:cover; border-radius:8px; border:1px solid #eee;">
        </div>
    @endif
    @error('image') <div class="error-text">{{ $message }}</div> @enderror
</div>

<div class="form-control-wrap checkbox-row">
    <input type="checkbox" id="is_featured" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured ?? false))>
    <label for="is_featured" style="margin:0; font-size:0.9rem;">Mark as Store Favourite (featured on homepage)</label>
</div>
