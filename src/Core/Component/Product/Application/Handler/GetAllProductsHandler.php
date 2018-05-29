<?php


namespace App\Core\Component\Product\Application\Handler;


use App\Core\Component\Product\Domain\Model\Product\Query\GetAllProducts;
use App\Core\Port\Secondary\Projection\Product\ProductFinderInterface;
use React\Promise\Deferred;

/**
 * Class GetAllProductsHandler
 * @package App\Core\Component\Product\Application\Handler
 */
class GetAllProductsHandler
{
    /**
     * @var ProductFinderInterface
     */
    private $productFinder;

    /**
     * GetAllProductsHandler constructor.
     * @param ProductFinderInterface $productFinder
     */
    public function __construct(ProductFinderInterface $productFinder)
    {
        $this->productFinder = $productFinder;
    }

    /**
     * @param GetAllProducts $getAllProducts
     * @param Deferred|null $deferred
     * @return void|array
     */
    public function __invoke(GetAllProducts $getAllProducts, Deferred $deferred)
    {
        $products = $this->productFinder->findAll();

        $deferred->resolve($products);
    }
}
