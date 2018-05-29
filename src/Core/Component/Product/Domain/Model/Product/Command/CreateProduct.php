<?php


namespace App\Core\Component\Product\Domain\Model\Product\Command;


use App\Core\Component\Product\Domain\Model\Product\ProductId;
use App\Core\Component\Shared\Types\CommandInterface;
use Assert\Assertion;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadTrait;

/**
 * Class CreateProduct
 * @package App\Core\Component\Product\Application\Command
 */
final class CreateProduct extends Command implements CommandInterface
{
    use PayloadTrait;

    /**
     * @return ProductId
     * @throws \Assert\AssertionFailedException
     */
    public function id(): ProductId
    {
        return ProductId::fromString($this->payload['id']);
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->payload['name'];
    }

    /**
     * @return float
     */
    public function price(): float
    {
        return $this->payload['price'];
    }

    /**
     * @param array $payload
     * @throws \Assert\AssertionFailedException
     */
    protected function setPayload(array $payload): void
    {
        Assertion::keyExists($payload, 'id');
        Assertion::keyExists($payload, 'name');
        Assertion::keyExists($payload, 'price');

        $this->payload = $payload;
    }
}
