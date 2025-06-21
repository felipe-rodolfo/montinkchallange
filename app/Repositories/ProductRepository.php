<?php

namespace App\Repositories;

use App\Models\product;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public function create(array $data): Product
    {
        return DB::transaction(function () use ($data) {
            $product = product::create([
                'name' => $data['name'],
                'price' => $data['price'],
                'variations' => $data['variations'] ?? [],
            ]);

            foreach ($data['stocks'] as $item) {
                $product->stocks()->create([
                    'variations' => $item['variations'] ?? null,
                    'quantity' => $item['quantity'],
                ]);
            }

            return $product;
        });
    }

    public function update(Product $product, array $data): Product
    {
        return DB::transaction(function () use ($product, $data) {
            $product->update([
                'name' => $data['name'],
                'price' => $data['price'],
                'variations' => $data['variations'] ?? [],
            ]);

            $product->stocks()->delete();

            foreach ($data['stocks'] as $item) {
                $product->stocks()->create([
                    'variations' => $item['variations'] ?? null,
                    'quantity' => $item['quantity'],
                ]);
            }

            return $product;
        });
    }
}
