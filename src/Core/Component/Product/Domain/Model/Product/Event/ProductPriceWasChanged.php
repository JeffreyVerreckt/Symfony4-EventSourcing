<?php


namespace App\Core\Component\Product\Domain\Model\Product\Event;


use App\Core\Component\Product\Domain\Model\Product\ProductId;
use App\Core\Component\Shared\Types\DomainEvent;
use Prooph\EventSourcing\AggregateChanged;

/**
 * Class ProductPriceWasChanged
 * @package App\Core\Component\Product\Domain\Model\Product\Event
 */
final class ProductPriceWasChanged extends AggregateChanged implements DomainEvent
{

    /**
     * @param ProductId $productId
     * @param float $price
     * @return ProductPriceWasChanged
     */
    public static function withData(ProductId $productId, float $price): ProductPriceWasChanged
    {
        return self::occur($productId->toString(), [
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
     * @return float
     */
    public function price(): float
    {
        return $this->payload['price'];
    }
}
