<?php


namespace App\Core\Port\Secondary\Repository;


use App\Core\Component\Product\Domain\Model\Product\Product;
use App\Core\Component\Product\Domain\Model\Product\ProductId;

/**
 * Interface ProductListInterface
 * @package App\Core\Port\Secondary\Repository
 */
interface ProductRepositoryInterface
{

    /**
     * @param ProductId $productId
     * @return null|Product
     */
    public function get(ProductId $productId): ?Product;

    /**
     * @param Product $product
     */
    public function save(Product $product): void;
}
