<?php

namespace App\Machine;

use InvalidArgumentException;

class Money implements MoneyInterface
{
    public function __construct(private int $amount)
    {
    }

    public static function fromFloat(float $amount): MoneyInterface
    {
        if ($amount < 0) {
            throw new InvalidArgumentException('Amount should be positive or 0');
        }

        return new self((int)($amount * 100));
    }

    public function toFloat(): float
    {
        return (float)($this->amount / 100);
    }

    public function toCents(): int
    {
        return $this->amount;
    }

    public function toString(): string
    {
        return (string)$this->toFloat();
    }

    public function mul(int $multiplayer): MoneyInterface
    {
        return new self($this->amount * $multiplayer);
    }

    public function sub(MoneyInterface $amount): MoneyInterface
    {
        $result = $this->amount - $amount->toCents();
        if ($result < 0) {
            throw new InvalidArgumentException('Amount should be positive or 0 after subtraction');
        }

        return new self($result);
    }

    public function amount(MoneyInterface $price): int
    {
        if ($this->amount < $price->toCents()) {
            return 0;
        }

        return (int)($this->amount / $price->toCents());
    }
}
