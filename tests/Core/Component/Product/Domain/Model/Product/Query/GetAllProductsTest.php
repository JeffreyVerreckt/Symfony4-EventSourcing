<?php


namespace App\Tests\Core\Component\Product\Domain\Model\Product\Query;


use App\Core\Component\Product\Domain\Model\Product\Query\GetAllProducts;
use PHPUnit\Framework\TestCase;

class GetAllProductsTest extends TestCase
{

    public function testIfClassExist(): void
    {
        $query = new GetAllProducts();
        $this->assertNotNull($query);
    }
}