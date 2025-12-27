<?php

namespace App\Actions\Product;

use App\Models\Product;
use App\Services\FileUploadService;

class DeleteProductAction
{
    public function __construct(
        private FileUploadService $fileUploadService
    ) {}

    /**
     * Execute the action to delete a product.
     *
     * @param Product $product
     * @return void
     * @throws \Exception
     */
    public function execute(Product $product): void
    {
        if ($product->cartItems()->exists() || $product->orderItems()->exists()) {
            throw new \Exception('Cannot delete product that has cart items or order items.');
        }

        // Delete product image if exists
        if ($product->image) {
            $this->fileUploadService->delete($product->image);
        }

        $product->delete();
    }
}

