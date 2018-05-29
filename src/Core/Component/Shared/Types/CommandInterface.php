<?php


namespace App\Core\Component\Shared\Types;


/**
 * Interface CommandInterface
 * @package App\Core\Component\Shared\Types
 */
interface CommandInterface
{
    public function __construct(array $payload = []);
}
