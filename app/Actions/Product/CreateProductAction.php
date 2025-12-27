<?php

namespace App\Actions\Product;

use App\Models\Product;
use App\Services\FileUploadService;

class CreateProductAction
{
    public function __construct(
        private FileUploadService $fileUploadService
    ) {}

    /**
     * Execute the action to create a new product.
     *
     * @param array<string, mixed> $data
     * @return Product
     */
    public function execute(array $data): Product
    {
        $productData = [
            'name' => $data['name'],
            'price' => $data['price'],
            'stock_quantity' => $data['stock_quantity'],
        ];

        if (isset($data['image']) && $data['image']) {
            $productData['image'] = $this->fileUploadService->upload(
                $data['image'],
                'products'
            );
        }

        return Product::create($productData);
    }
}

