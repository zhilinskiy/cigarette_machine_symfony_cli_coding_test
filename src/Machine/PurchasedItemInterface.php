<?php

namespace App\Machine;

/**
 * Interface PurchasedItemInterface
 * @package App\Machine
 */
interface PurchasedItemInterface
{

    public function getItemQuantity(): int;

    public function getTotalAmount(): float;

    /**
     * Returns the change in this format:
     *
     * Coin Count
     * 0.01 0
     * 0.02 0
     * .... .....
     */
    public function getChange(): array;
}
