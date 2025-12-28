<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ShopController extends Controller
{
    /**
     * Display the shop page with products
     */
    public function index(Request $request): Response
    {
        $query = Product::query();

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Stock filter
        if ($request->filled('in_stock') && $request->in_stock) {
            $query->where('stock_quantity', '>', 0);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $query->orderBy($sortBy, $sortOrder);

        // Paginate
        $products = $query->paginate(12)->withQueryString();

        // Add image URLs
        $products->getCollection()->transform(function ($product) {
            if ($product->image) {
                $product->image_url = asset('storage/' . $product->image);
            }
            return $product;
        });

        // Get price range for filters
        $priceRange = [
            'min' => Product::min('price') ?? 0,
            'max' => Product::max('price') ?? 1000,
        ];

        return Inertia::render('client/Shop', [
            'products' => $products,
            'filters' => [
                'search' => $request->search,
                'min_price' => $request->min_price,
                'max_price' => $request->max_price,
                'in_stock' => $request->boolean('in_stock'),
                'sort_by' => $sortBy,
                'sort_order' => $sortOrder,
            ],
            'priceRange' => $priceRange,
        ]);
    }
}
