<?php


namespace App\Infrastructure\Repository;

use App\Core\Component\Product\Domain\Model\Product\Product;
use App\Core\Component\Product\Domain\Model\Product\ProductId;
use App\Core\Port\Secondary\Repository\ProductRepositoryInterface;
use Prooph\EventSourcing\Aggregate\AggregateRepository;

/**
 * Class EventStoreProductRepository
 * @package App\Infrastructure\Repository
 */
final class EventStoreProductRepository extends AggregateRepository implements ProductRepositoryInterface
{

    /**
     * @param ProductId $productId
     * @return null|Product
     */
    public function get(ProductId $productId): ?Product
    {
        return $this->getAggregateRoot((string)$productId);
    }

    /**
     * @param Product $product
     */
    public function save(Product $product): void
    {
        $this->saveAggregateRoot($product);
    }
}
