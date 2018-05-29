<?php


namespace App\Infrastructure\Projection\Product;

use App\Core\Component\Product\Domain\Model\Product\Event\ProductPriceWasChanged;
use App\Core\Component\Product\Domain\Model\Product\Event\ProductWasCreated;
use Prooph\Bundle\EventStore\Projection\ReadModelProjection;
use Prooph\EventStore\Projection\ReadModelProjector;

/**
 * Class ProductProjection
 * @package App\Infrastructure\Projection\Product
 */
final class ProductProjection implements ReadModelProjection
{

    /**
     * @param ReadModelProjector $projector
     * @return ReadModelProjector
     */
    public function project(ReadModelProjector $projector): ReadModelProjector
    {
        $projector->fromStream('event_stream')
            ->when([
                ProductWasCreated::class => function ($state, ProductWasCreated $event) {
                    /** @var ProductReadModel $readModel */
                    $readModel = $this->readModel();
                    $readModel->stack('insert', [
                        'id' => (string)$event->productId(),
                        'name' => $event->name(),
                        'price' => $event->price(),
                    ]);
                },
                ProductPriceWasChanged::class => function ($state, ProductPriceWasChanged $event) {
                    /** @var ProductReadModel $readModel */
                    $readModel = $this->readModel();
                    $readModel->stack('update', [
                        'price' => $event->price(),
                    ], [
                        'id' => (string)$event->productId(),
                    ]);
                },
            ]);
        return $projector;
    }
}