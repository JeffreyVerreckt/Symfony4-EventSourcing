<?php


namespace App\Core\Component\Product\Domain\Model\Product;


use App\Core\Component\Shared\Types\IdentifiesAggregate;
use Assert\Assertion;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class ProductId
 * @package App\Core\Component\Product\Domain\Model
 */
final class ProductId implements IdentifiesAggregate
{
    /**
     * @var UuidInterface
     */
    private $uuid;

    /**
     * ProductId constructor.
     * @param UuidInterface $uuid
     * @throws \Assert\AssertionFailedException
     */
    public function __construct(UuidInterface $uuid)
    {
        Assertion::uuid($uuid);

        $this->uuid = $uuid;
    }

    /**
     * @param string $productId
     * @return ProductId
     * @throws \Assert\AssertionFailedException
     */
    public static function fromString(string $productId): ProductId
    {
        return new self(Uuid::fromString($productId));
    }

    /**
     * @return UuidInterface
     */
    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->uuid->toString();
    }

    /**
     * @param $other
     * @return boolean
     */
    public function equals(IdentifiesAggregate $other): bool
    {
        return $other instanceof self && $this->uuid->equals($other->uuid);
    }
}
