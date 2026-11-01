<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Core\Database;

final class BannerRepository
{
    public function activeList(): array
    {
        $statement = Database::connection()->query(
            'SELECT * FROM banners WHERE is_active = 1 ORDER BY sort_order ASC, id DESC'
        );

        return $statement->fetchAll();
    }

    public function adminList(): array
    {
        $statement = Database::connection()->query(
            'SELECT * FROM banners ORDER BY sort_order ASC, id DESC'
        );

        return $statement->fetchAll();
    }
}
