<?php


namespace App\Core\Component\Product\Domain\Model\Product\Query;

use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;
use Prooph\Common\Messaging\Query;

/**
 * Class GetAllProducts
 * @package App\Core\Component\Product\Application\Query
 */
final class GetAllProducts extends Query implements PayloadConstructable
{
    use PayloadTrait;
}
