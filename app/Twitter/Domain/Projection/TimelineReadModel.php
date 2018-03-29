<?php

declare(strict_types=1);

namespace App\Twitter\Domain\Projection;

use Doctrine\DBAL\Connection;
use Prooph\EventStore\Projection\AbstractReadModel;

final class TimelineReadModel extends AbstractReadModel
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function init(): void
    {
        $tablename = Table::TIMELINE;

        $sql = <<<EOT
CREATE TABLE `$tablename` (
  `id` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
  `author` VARCHAR(255) NOT NULL,
  `tweet` varchar(140) COLLATE utf8_unicode_ci NOT NULL,
  `tweeted_at` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
EOT;

        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }

    public function isInitialized(): bool
    {
        $tableName = Table::TIMELINE;

        $sql = "SHOW TABLES LIKE '$tableName';";

        $statement = $this->connection->prepare($sql);
        $statement->execute();

        return (bool) $statement->fetch();
    }

    public function reset(): void
    {
        $tableName = Table::TIMELINE;

        $sql = "TRUNCATE TABLE $tableName;";

        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }

    public function delete(): void
    {
        $tableName = Table::TIMELINE;

        $sql = "DROP TABLE $tableName;";

        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }

    protected function insert(array $data): void
    {
        $this->connection->insert(Table::TIMELINE, $data);
    }
}
