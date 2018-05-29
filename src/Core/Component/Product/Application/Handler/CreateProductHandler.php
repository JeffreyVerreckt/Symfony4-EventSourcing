<?php


namespace App\Core\Component\Product\Application\Handler;


use App\Core\Component\Product\Domain\Model\Product\Command\CreateProduct;
use App\Core\Component\Product\Domain\Model\Product\Product;
use App\Core\Port\Secondary\Repository\ProductRepositoryInterface;

/**
 * Class CreateProductHandler
 * @package App\Core\Component\Product\Application\Handler
 */
class CreateProductHandler
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * CreateProductHandler constructor.
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param CreateProduct $command
     */
    public function __invoke(CreateProduct $command): void
    {
        $product = $this->productRepository->get($command->id());
        if ($product) {
            throw new \DomainException('Product already exists.');
        }

        $product = Product::create($command->id(), $command->name(), $command->price());
        $this->productRepository->save($product);
    }
}
