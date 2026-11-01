<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;
use PDO;

final class CategoryRepository
{
    private function connection(): PDO
    {
        return Database::connection();
    }

    public function activeList(): array
    {
        $statement = $this->connection()->query(
            'SELECT c.*, COUNT(p.id) AS products_count
             FROM categories c
             LEFT JOIN products p ON p.category_id = c.id AND p.is_active = 1
             WHERE c.is_active = 1
             GROUP BY c.id
             ORDER BY c.sort_order ASC, c.id ASC'
        );

        return $statement->fetchAll();
    }

    public function adminList(): array
    {
        $statement = $this->connection()->query(
            'SELECT c.*, COUNT(p.id) AS products_count
             FROM categories c
             LEFT JOIN products p ON p.category_id = c.id
             GROUP BY c.id
             ORDER BY c.sort_order ASC, c.id ASC'
        );

        return $statement->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $statement = $this->connection()->prepare('SELECT * FROM categories WHERE id = :id LIMIT 1');
        $statement->execute(['id' => $id]);
        $row = $statement->fetch();

        return $row ?: null;
    }

    public function findBySlug(string $slug): ?array
    {
        $statement = $this->connection()->prepare('SELECT * FROM categories WHERE slug = :slug LIMIT 1');
        $statement->execute(['slug' => $slug]);
        $row = $statement->fetch();

        return $row ?: null;
    }

    public function create(array $data): int
    {
        $statement = $this->connection()->prepare(
            'INSERT INTO categories (name, slug, description, image_path, is_active, sort_order)
             VALUES (:name, :slug, :description, :image_path, :is_active, :sort_order)'
        );
        $statement->execute($this->normalize($data));

        return (int) $this->connection()->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $values = $this->normalize($data);
        $values['id'] = $id;
        $statement = $this->connection()->prepare(
            'UPDATE categories SET name = :name, slug = :slug, description = :description,
                image_path = :image_path, is_active = :is_active, sort_order = :sort_order
             WHERE id = :id'
        );
        $statement->execute($values);

        return $statement->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        $statement = $this->connection()->prepare('DELETE FROM categories WHERE id = :id');
        $statement->execute(['id' => $id]);

        return $statement->rowCount() > 0;
    }

    private function normalize(array $data): array
    {
        return [
            'name' => trim((string) ($data['name'] ?? '')),
            'slug' => trim((string) ($data['slug'] ?? '')),
            'description' => ($data['description'] ?? '') !== '' ? (string) $data['description'] : null,
            'image_path' => ($data['image_path'] ?? '') !== '' ? (string) $data['image_path'] : null,
            'is_active' => !empty($data['is_active']) ? 1 : 0,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
        ];
    }
}
