<?php

declare(strict_types=1);

namespace App\Twitter\Domain\Projection;

use Doctrine\DBAL\Connection;

final class MyTimelineFinder
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->connection->setFetchMode(\PDO::FETCH_OBJ);
    }

    public function findAll(): array
    {
        return $this->connection->fetchAll(
            sprintf('SELECT * FROM %s ORDER BY `twitter-es`.read_timeline.tweeted_at DESC', Table::TIMELINE)
        );
    }
}
