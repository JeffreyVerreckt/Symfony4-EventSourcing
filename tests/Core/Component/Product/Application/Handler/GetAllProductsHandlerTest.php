<?php


namespace App\Tests\Core\Component\Product\Application\Handler;


use App\Core\Component\Product\Application\Handler\GetAllProductsHandler;
use App\Core\Component\Product\Domain\Model\Product\Query\GetAllProducts;
use App\Core\Port\Secondary\Projection\Product\ProductFinderInterface;
use PHPUnit\Framework\TestCase;
use React\Promise\Deferred;

class GetAllProductsHandlerTest extends TestCase
{

    private $productFinder;

    public function testQuery(): void
    {
        $handler = $this->createGetAllProductsHandler();

        $this->productFinder->findAll()->shouldBeCalled();

        $query = new GetAllProducts();
        $deferred = new Deferred();
        $handler($query, $deferred);

        $called= false;
        $deferred->promise()->done(function () use (&$called) {
            $called = true;
        });

        $this->assertTrue($called);
    }

    private function createGetAllProductsHandler(): GetAllProductsHandler
    {
        $this->productFinder = $this->prophesize(ProductFinderInterface::class);
        return new GetAllProductsHandler($this->productFinder->reveal());
    }
}