<?php


namespace App\Infrastructure\Projection\Product;


use App\Core\Port\Secondary\Projection\Product\ProductFinderInterface;
use App\Infrastructure\Projection\Table;
use Doctrine\DBAL\Connection;

/**
 * Class ProductFinder
 * @package App\Infrastructure\Projection\Product
 */
final class ProductFinder implements ProductFinderInterface
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * ProductFinder constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->connection->setFetchMode(\PDO::FETCH_OBJ);
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->connection->fetchAll(sprintf('SELECT * FROM %s', Table::PRODUCT));
    }
}
