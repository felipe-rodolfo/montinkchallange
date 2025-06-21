<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Support\Collection;

class ProductService
{
    public function __construct(protected ProductRepository $repo) {}

    public function all(): Collection
    {
        return $this->repo->products()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'variations' => $this->formatVariations($product->variations),
                'price' => $product->price,
                'quantity' => $product->stocks->first()?->quantity ?? 0,
                'total' => $product->price * ($product->stocks->first()?->quantity ?? 0),
            ];
        });
    }

    private function formatVariations($variations): string
    {
        if (is_array($variations)) {
            return implode(', ', $variations);
        }

        if (is_string($variations)) {
            $decoded = json_decode($variations, true);
            return is_array($decoded) ? implode(', ', $decoded) : $variations;
        }

        return '-';
    }

    public function store(array $data): Product
    {
        return $this->repo->create($data);
    }

    public function update(Product $product, array $data): Product
    {
        return $this->repo->update($product, $data);
    }
}
