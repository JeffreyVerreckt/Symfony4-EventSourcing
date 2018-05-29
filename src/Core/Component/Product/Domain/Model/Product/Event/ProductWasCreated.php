<?php


namespace App\Core\Component\Product\Domain\Model\Product\Event;

use App\Core\Component\Product\Domain\Model\Product\ProductId;
use App\Core\Component\Shared\Types\DomainEvent;
use App\Core\Component\Shared\Types\IdentifiesAggregate;
use Prooph\EventSourcing\AggregateChanged;

/**
 * Class ProductWasCreated
 * @package App\Core\Component\Product\Domain\Model\Product\Event
 */
final class ProductWasCreated extends AggregateChanged implements DomainEvent
{
    /**
     * @param ProductId $productId
     * @param string $name
     * @param float $price
     * @return ProductWasCreated
     */
    public static function withData(ProductId $productId, string $name, float $price): ProductWasCreated
    {
        return self::occur($productId->toString(), [
            'name' => $name,
            'price' => $price,
        ]);
    }

    /**
     * @return ProductId
     */
    public function productId(): ProductId
    {
        return ProductId::fromString($this->aggregateId());
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->payload['name'];
    }

    /**
     * @return float
     */
    public function price(): float
    {
        return $this->payload['price'];
    }
}
