<?php

namespace App\Machine;

interface MoneyInterface
{
    public static function fromFloat(float $amount): self;

    public function toFloat(): float;

    public function toCents(): int;

    public function toString(): string;

    public function mul(int $multiplayer): self;

    public function sub(self $amount): self;

    public function amount(self $price): int;
}
