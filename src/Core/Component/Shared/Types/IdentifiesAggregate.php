<?php

namespace App\Core\Component\Shared\Types;

/**
 * Interface IdentifiesAggregate
 * @package Buttercup\Protects
 */
interface IdentifiesAggregate
{
    /**
     * @param string $string
     * @return object
     */
    public static function fromString(string $string);

    /**
     * @return string
     */
    public function toString(): string;

    /**
     * @param $other
     * @return boolean
     */
    public function equals(IdentifiesAggregate $other): bool;
}
