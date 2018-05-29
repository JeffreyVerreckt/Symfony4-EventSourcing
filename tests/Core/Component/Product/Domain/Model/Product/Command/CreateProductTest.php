<?php


namespace App\Tests\Core\Component\Product\Domain\Model\Product\Command;



use App\Core\Component\Product\Domain\Model\Product\Command\CreateProduct;
use App\Core\Component\Product\Domain\Model\Product\ProductId;
use PHPUnit\Framework\TestCase;

class CreateProductTest extends TestCase
{

    public function testPayload(): void
    {
        $productId = '9f9aa346-7ef0-460f-b6ae-6bdb9c3b6d4d';
        $name = 'Product 1';
        $price = 10;

        $payload = [
            'id' => $productId,
            'name' => $name,
            'price' => $price,
        ];
        $command = new CreateProduct($payload);

        $this->assertEquals($productId, $command->id()->toString());
        $this->assertEquals($name, $command->name());
        $this->assertEquals($price, $command->price());
    }
}