<?php


namespace App\Tests\Core\Component\Product\Application\Handler;


use App\Core\Component\Product\Application\Handler\ChangeProductPriceHandler;
use App\Core\Component\Product\Domain\Model\Product\Command\ChangeProductPrice;
use App\Core\Component\Product\Domain\Model\Product\Product;
use App\Core\Component\Product\Domain\Model\Product\ProductId;
use App\Core\Port\Secondary\Repository\ProductRepositoryInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class ChangeProductPriceHandlerTest extends TestCase
{
    private $productRepository;

    public function testInvokeNewProduct(): void
    {
        $handler = $this->createCreateProductHandler();
        $productData = [
            'id' => '9f9aa346-7ef0-460f-b6ae-6bdb9c3b6d4d',
            'name' => 'Product1',
            'price' => 10,
        ];
        $product = Product::create(ProductId::fromString($productData['id']), $productData['name'], $productData['price']);
        $this->productRepository->get(Argument::any())->willReturn($product);
        $this->productRepository->save(Argument::type(Product::class))->shouldBeCalled();

        $command = new ChangeProductPrice([
            'id' => $productData['id'],
            'price' => $productData['price'],
        ]);
        $handler($command);
    }

    private function createCreateProductHandler(): ChangeProductPriceHandler
    {
        $this->productRepository = $this->prophesize(ProductRepositoryInterface::class);
        return new ChangeProductPriceHandler($this->productRepository->reveal());
    }
}