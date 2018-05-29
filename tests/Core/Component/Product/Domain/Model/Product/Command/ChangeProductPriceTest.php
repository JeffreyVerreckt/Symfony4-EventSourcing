<?php


namespace App\Tests\Core\Component\Product\Domain\Model\Product\Command;


use App\Core\Component\Product\Domain\Model\Product\Command\ChangeProductPrice;
use App\Core\Component\Product\Domain\Model\Product\ProductId;
use PHPUnit\Framework\TestCase;

class ChangeProductPriceTest extends TestCase
{

    public function testPayload(): void
    {
        $productId = '9f9aa346-7ef0-460f-b6ae-6bdb9c3b6d4d';
        $price = 15;

        $payload = [
            'id' => $productId,
            'price' => $price,
        ];

        $command = new ChangeProductPrice($payload);

        $this->assertEquals($productId, $command->id()->toString());
        $this->assertEquals($price, $command->price());
    }
}