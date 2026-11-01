<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use PDO;

final class ProductRepository
{
    private function connection(): PDO
    {
        return Database::connection();
    }

    public function activeList(): array
    {
        $statement = $this->connection()->query(
            'SELECT p.*, c.name AS category_name, c.slug AS category_slug
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.is_active = 1
             ORDER BY p.sort_order ASC, p.id DESC'
        );

        return $statement->fetchAll();
    }

    public function featuredList(): array
    {
        $statement = $this->connection()->query(
            'SELECT p.*, c.name AS category_name, c.slug AS category_slug
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.is_active = 1 AND p.featured = 1
             ORDER BY p.sort_order ASC, p.id DESC'
        );

        return $statement->fetchAll();
    }

    public function findActiveBySlug(string $slug): ?array
    {
        $statement = $this->connection()->prepare(
            'SELECT p.*, c.name AS category_name, c.slug AS category_slug
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.slug = :slug AND p.is_active = 1
             LIMIT 1'
        );
        $statement->execute(['slug' => $slug]);
        $row = $statement->fetch();

        return $row ?: null;
    }

    public function findById(int $id): ?array
    {
        $statement = $this->connection()->prepare(
            'SELECT p.*, c.name AS category_name
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.id = :id LIMIT 1'
        );
        $statement->execute(['id' => $id]);
        $row = $statement->fetch();

        return $row ?: null;
    }

    public function adminList(): array
    {
        $statement = $this->connection()->query(
            'SELECT p.*, c.name AS category_name
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             ORDER BY p.sort_order ASC, p.id DESC'
        );

        return $statement->fetchAll();
    }

    public function create(array $data): int
    {
        $statement = $this->connection()->prepare(
            'INSERT INTO products
                (category_id, name, slug, short_description, description, image_path, featured, is_active, sort_order)
             VALUES
                (:category_id, :name, :slug, :short_description, :description, :image_path, :featured, :is_active, :sort_order)'
        );
        $statement->execute($this->normalize($data));

        return (int) $this->connection()->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $values = $this->normalize($data);
        $values['id'] = $id;

        $statement = $this->connection()->prepare(
            'UPDATE products SET
                category_id = :category_id,
                name = :name,
                slug = :slug,
                short_description = :short_description,
                description = :description,
                image_path = :image_path,
                featured = :featured,
                is_active = :is_active,
                sort_order = :sort_order
             WHERE id = :id'
        );

        $statement->execute($values);
        return $statement->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        $statement = $this->connection()->prepare('DELETE FROM products WHERE id = :id');
        $statement->execute(['id' => $id]);

        return $statement->rowCount() > 0;
    }

    private function normalize(array $data): array
    {
        return [
            'category_id' => isset($data['category_id']) && $data['category_id'] !== ''
                ? (int) $data['category_id'] : null,
            'name' => trim((string) ($data['name'] ?? '')),
            'slug' => trim((string) ($data['slug'] ?? '')),
            'short_description' => ($data['short_description'] ?? '') !== ''
                ? (string) $data['short_description'] : null,
            'description' => ($data['description'] ?? '') !== ''
                ? (string) $data['description'] : null,
            'image_path' => ($data['image_path'] ?? '') !== ''
                ? (string) $data['image_path'] : null,
            'featured' => !empty($data['featured']) ? 1 : 0,
            'is_active' => !empty($data['is_active']) ? 1 : 0,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
        ];
    }
}
