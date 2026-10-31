<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Database;
use App\Core\JsonStore;
use PDO;

final class CatalogService
{
    public function __construct(private readonly JsonStore $store = new JsonStore()) {}

    public function products(): array
    {
        if (!Database::configured()) {
            return $this->store->read('products.json', []);
        }

        $statement = Database::connection()->query(
            'SELECT p.*, c.name AS category_name, c.slug AS category_slug
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.is_active = 1
             ORDER BY p.sort_order ASC, p.id DESC'
        );

        return $statement->fetchAll();
    }

    public function categories(): array
    {
        if (!Database::configured()) {
            return $this->store->read('categories.json', []);
        }

        $statement = Database::connection()->query(
            'SELECT * FROM categories
             WHERE is_active = 1
             ORDER BY sort_order ASC, id ASC'
        );

        return $statement->fetchAll();
    }

    public function featuredProducts(): array
    {
        if (!Database::configured()) {
            return array_values(array_filter(
                $this->products(),
                static fn (array $product): bool => ($product['featured'] ?? false) === true
            ));
        }

        $statement = Database::connection()->query(
            'SELECT p.*, c.name AS category_name, c.slug AS category_slug
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.is_active = 1 AND p.featured = 1
             ORDER BY p.sort_order ASC, p.id DESC'
        );

        return $statement->fetchAll();
    }

    public function findProductBySlug(string $slug): ?array
    {
        if (!Database::configured()) {
            foreach ($this->products() as $product) {
                if (($product['slug'] ?? '') === $slug) {
                    return $product;
                }
            }
            return null;
        }

        $statement = Database::connection()->prepare(
            'SELECT p.*, c.name AS category_name, c.slug AS category_slug
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.slug = :slug AND p.is_active = 1
             LIMIT 1'
        );
        $statement->execute(['slug' => $slug]);
        $product = $statement->fetch();

        return $product ?: null;
    }
}
