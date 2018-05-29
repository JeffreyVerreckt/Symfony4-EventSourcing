<?php


namespace App\Core\Component\Product\Application\Handler;


use App\Core\Component\Product\Domain\Model\Product\Command\ChangeProductPrice;
use App\Core\Port\Secondary\Repository\ProductRepositoryInterface;

/**
 * Class ChangeProductPriceHandler
 * @package App\Core\Component\Product\Application\Handler
 */
class ChangeProductPriceHandler
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * ChangeProductPriceHandler constructor.
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param ChangeProductPrice $command
     */
    public function __invoke(ChangeProductPrice $command): void
    {
        $product = $this->productRepository->get($command->id());
        if (!$product) {
            throw new \LogicException('Product with id ' . $command->id()->toString() . ' not found!');
        }

        $product->changePrice($command->price());
        $this->productRepository->save($product);
    }
}
