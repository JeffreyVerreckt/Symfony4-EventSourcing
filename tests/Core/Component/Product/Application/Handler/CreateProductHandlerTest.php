<?php


namespace App\Tests\Core\Component\Product\Application\Handler;


use App\Core\Component\Product\Application\Handler\CreateProductHandler;
use App\Core\Component\Product\Domain\Model\Product\Command\CreateProduct;
use App\Core\Component\Product\Domain\Model\Product\Product;
use App\Core\Port\Secondary\Repository\ProductRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class CreateProductHandlerTest extends TestCase
{

    private $productRepository;

    public function testInvokeNewProduct(): void
    {
        $handler = $this->createCreateProductHandler();

        $command = new CreateProduct([
            'id' => '9f9aa346-7ef0-460f-b6ae-6bdb9c3b6d4d',
            'name' => 'Product 1',
            'price' => 10,
        ]);
        $handler($command);

        $this->productRepository->save(Argument::type(Product::class))->shouldBeCalled();
    }

    private function createCreateProductHandler(): CreateProductHandler
    {
        $this->productRepository = $this->prophesize(ProductRepositoryInterface::class);
        return new CreateProductHandler($this->productRepository->reveal());
    }
}