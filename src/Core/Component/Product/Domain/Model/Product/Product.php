<?php


namespace App\Core\Component\Product\Domain\Model\Product;


use App\Core\Component\Product\Domain\Model\Product\Event\ProductPriceWasChanged;
use App\Core\Component\Product\Domain\Model\Product\Event\ProductWasCreated;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;

/**
 * Class Product
 * @package App\Core\Component\Product\Domain\Model
 */
class Product extends AggregateRoot
{
    /**
     * @var ProductId
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $price;

    /**
     * @param ProductId $id
     * @param string $name
     * @param float $price
     * @return Product
     */
    public static function create(ProductId $id, string $name, float $price): Product
    {
        $self = new self();
        $self->recordThat(ProductWasCreated::withData($id, $name, $price));

        return $self;
    }

    /**
     * @param float $price
     */
    public function changePrice(float $price): void
    {
        $this->recordThat(ProductPriceWasChanged::withData($this->id, $price));
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function price(): float
    {
        return $this->price;
    }

    /**
     * @param ProductWasCreated $event
     */
    protected function whenProductWasCreated(ProductWasCreated $event): void
    {
        $this->id = $event->productId();
        $this->name = $event->name();
        $this->price = $event->price();
    }

    /**
     * @param ProductWasCreated $event
     */
    protected function whenProductPriceWasChanged(ProductPriceWasChanged $event): void
    {
        $this->price = $event->price();
    }

    /**
     * @return string
     */
    protected function aggregateId(): string
    {
        return $this->id->toString();
    }

    /**
     * @param AggregateChanged $event
     */
    protected function apply(AggregateChanged $event): void
    {
        $handler = $this->determineEventHandlerMethodFor($event);
        if (!method_exists($this, $handler)) {
            throw new \RuntimeException(sprintf(
                'Missing event handler method %s for aggregate root %s',
                $handler,
                \get_class($this)
            ));
        }
        $this->{$handler}($event);
    }

    /**
     * @param AggregateChanged $event
     * @return string
     */
    protected function determineEventHandlerMethodFor(AggregateChanged $event): string
    {
        return 'when'.implode(\array_slice(explode('\\', \get_class($event)), -1));
    }
}
