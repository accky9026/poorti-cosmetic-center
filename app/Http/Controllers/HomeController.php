<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        $featured = Product::where('is_featured', true)->latest()->take(4)->get();
        $products = $query->latest()->paginate(8)->withQueryString();
        $categories = Product::select('category')->distinct()->pluck('category');

        return view('home', compact('featured', 'products', 'categories'));
    }
}
