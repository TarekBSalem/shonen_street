<?php

namespace App\Actions\Product;

use App\Models\Product;
use App\Services\FileUploadService;

class UpdateProductAction
{
    public function __construct(
        private FileUploadService $fileUploadService
    ) {}

    /**
     * Execute the action to update a product.
     *
     * @param Product $product
     * @param array<string, mixed> $data
     * @return Product
     */
    public function execute(Product $product, array $data): Product
    {
        $productData = [
            'name' => $data['name'],
            'price' => $data['price'],
            'stock_quantity' => $data['stock_quantity'],
        ];

        if (isset($data['image']) && $data['image']) {
            // Delete old image if exists
            if ($product->image) {
                $this->fileUploadService->delete($product->image);
            }

            $productData['image'] = $this->fileUploadService->upload(
                $data['image'],
                'products'
            );
        }

        $product->update($productData);

        return $product->fresh();
    }
}

