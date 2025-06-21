<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;

class ProductService
{
    public function __construct(protected ProductRepository $repo) {}

    public function store(array $data): Product
    {
        return $this->repo->create($data);
    }

    public function update(Product $product, array $data): Product
    {
        return $this->repo->update($product, $data);
    }
}
