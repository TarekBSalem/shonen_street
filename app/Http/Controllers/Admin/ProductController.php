<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Product\CreateProductAction;
use App\Actions\Product\DeleteProductAction;
use App\Actions\Product\UpdateProductAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(): Response
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(15)->through(
            fn($product) => [
                'id' => $product->id,
                'name' => $product->name,
                'image' => $product->image ? asset('storage/' . $product->image) : null,
                'price' => $product->price,
                'stock_quantity' => $product->stock_quantity,
                'created_at' => $product->created_at->format('Y-m-d H:i'),
            ],
        );

        return Inertia::render('admin/products/Index', [
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created product.
     */
    public function store(StoreProductRequest $request, CreateProductAction $action)
    {
        try {
            $product = $action->execute($request->validated());

            return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create product: ' . $e->getMessage()]);
        }
    }

    /**
     * Update the specified product.
     */
    public function update(UpdateProductRequest $request, Product $product, UpdateProductAction $action)
    {
        try {
            $action->execute($product, $request->validated());

            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update product: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product, DeleteProductAction $action)
    {
        try {
            $action->execute($product);

            return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}

