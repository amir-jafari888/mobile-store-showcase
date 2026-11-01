<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Database;
use App\Core\JsonStore;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;

final class CatalogService
{
    public function __construct(
        private readonly JsonStore $store = new JsonStore(),
        private readonly ProductRepository $productRepository = new ProductRepository(),
        private readonly CategoryRepository $categoryRepository = new CategoryRepository()
    ) {}

    public function products(): array
    {
        return Database::configured()
            ? $this->productRepository->activeList()
            : $this->store->read('products.json', []);
    }

    public function categories(): array
    {
        return Database::configured()
            ? $this->categoryRepository->activeList()
            : $this->store->read('categories.json', []);
    }

    public function featuredProducts(): array
    {
        if (Database::configured()) {
            return $this->productRepository->featuredList();
        }

        return array_values(array_filter(
            $this->products(),
            static fn (array $product): bool => in_array($product['featured'] ?? false, [true, 1, '1'], true)
        ));
    }

    public function findProductBySlug(string $slug): ?array
    {
        if (Database::configured()) {
            return $this->productRepository->findActiveBySlug($slug);
        }

        foreach ($this->products() as $product) {
            if (($product['slug'] ?? '') === $slug) {
                return $product;
            }
        }

        return null;
    }
}
