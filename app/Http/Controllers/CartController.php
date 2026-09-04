<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $items = CartService::items();
        $total = CartService::total($items);

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $quantity = max(1, (int) $request->input('quantity', 1));

        if ($product->stock < 1) {
            return back()->with('error', $product->name.' is currently out of stock.');
        }

        CartService::add($product->id, $quantity);

        return back()->with('success', $product->name.' added to your cart.');
    }

    public function update(Request $request, Product $product)
    {
        $quantity = max(1, (int) $request->input('quantity', 1));

        CartService::setQuantity($product->id, $quantity);

        return back()->with('success', 'Cart updated.');
    }

    public function remove(Product $product)
    {
        CartService::remove($product->id);

        return back()->with('success', 'Item removed from your cart.');
    }
}
