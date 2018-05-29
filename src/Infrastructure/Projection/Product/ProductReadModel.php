<?php


namespace App\Infrastructure\Projection\Product;


use App\Infrastructure\Projection\Table;
use Doctrine\DBAL\Connection;
use Prooph\EventStore\Projection\AbstractReadModel;

/**
 * Class ProductReadModel
 * @package App\Infrastructure\Projection\Product
 */
final class ProductReadModel extends AbstractReadModel
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * ProductReadModel constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    public function init(): void
    {
        $tableName = Table::PRODUCT;

        $sql = <<<EOT
CREATE TABLE `$tableName` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
EOT;
        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }

    /**
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function isInitialized(): bool
    {
        $tableName = Table::PRODUCT;
        $sql = "SHOW TABLES LIKE '$tableName';";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetch();

        return (bool)$result;
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    public function reset(): void
    {
        $tableName = Table::PRODUCT;
        $sql = "TRUNCATE TABLE '$tableName';";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    public function delete(): void
    {
        $tableName = Table::PRODUCT;
        $sql = "DROP TABLE $tableName;";
        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }

    /**
     * @param array $data
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function insert(array $data): void
    {
        $this->connection->insert(Table::PRODUCT, $data);
    }

    /**
     * @param array $data
     * @param array $identifier
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function update(array $data, array $identifier): void
    {
        $this->connection->update(Table::PRODUCT, $data, $identifier);
    }
}
