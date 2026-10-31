<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\JsonStore;

final class CatalogService
{
    public function __construct(private readonly JsonStore $store = new JsonStore()) {}

    public function products(): array
    {
        return $this->store->read('products.json', []);
    }

    public function categories(): array
    {
        return $this->store->read('categories.json', []);
    }

    public function featuredProducts(): array
    {
        return array_values(array_filter(
            $this->products(),
            static fn (array $product): bool => ($product['featured'] ?? false) === true
        ));
    }
}
