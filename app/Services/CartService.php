<?php

namespace App\Services;

use App\Models\Product;

class CartService
{
    /**
     * Return cart line items with live product data + calculated subtotal.
     */
    public static function items(): array
    {
        $cart = session()->get('cart', []);
        $items = [];

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);

            if (! $product) {
                continue;
            }

            $items[] = [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => round($product->final_price * $quantity, 2),
            ];
        }

        return $items;
    }

    public static function total(?array $items = null): float
    {
        $items = $items ?? self::items();

        return round(array_sum(array_column($items, 'subtotal')), 2);
    }

    /**
     * Total number of units in the cart (for the navbar badge).
     */
    public static function count(): int
    {
        return (int) array_sum(session()->get('cart', []));
    }

    public static function add(int $productId, int $quantity = 1): void
    {
        $cart = session()->get('cart', []);
        $cart[$productId] = ($cart[$productId] ?? 0) + max(1, $quantity);
        session()->put('cart', $cart);
    }

    public static function setQuantity(int $productId, int $quantity): void
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId] = max(1, $quantity);
            session()->put('cart', $cart);
        }
    }

    public static function remove(int $productId): void
    {
        $cart = session()->get('cart', []);
        unset($cart[$productId]);
        session()->put('cart', $cart);
    }

    public static function clear(): void
    {
        session()->forget('cart');
    }
}
