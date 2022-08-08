<?php
declare(strict_types=1);

namespace Tests\Unit;

use App\Machine\CigaretteMachine;
use App\Machine\PurchaseTransaction;
use PHPUnit\Framework\TestCase;

/**
 * @covers CigaretteMachine
 */
class CigaretteMachineTest extends TestCase
{
    private CigaretteMachine $machine;

    protected function setUp(): void
    {
        $this->machine = new CigaretteMachine();
    }

    public function test_when_pay_not_enough_for_buy(): void
    {
        $itemCount = 1;
        $amount = 0.08;
        $transaction = new PurchaseTransaction($itemCount, $amount);
        $purchasedItem = $this->machine->execute($transaction);

        $this->assertSame(0, $purchasedItem->getItemQuantity());
        $this->assertSame(0.0, $purchasedItem->getTotalAmount());
        $coinsChange = [
            '0.05' => 1,
            '0.02' => 1,
            '0.01' => 1,
        ];
        $this->assertSame($coinsChange, $purchasedItem->getChange());
    }

    public function test_when_ordered_amount_bigger_than_payed_amount(): void
    {
        $itemCount = 2;
        $amount = 5.0;
        $transaction = new PurchaseTransaction($itemCount, $amount);
        $purchasedItem = $this->machine->execute($transaction);

        $this->assertSame(1, $purchasedItem->getItemQuantity());
        $this->assertSame(4.99, $purchasedItem->getTotalAmount());
        $coinsChange = [
            '0.05' => 0,
            '0.02' => 0,
            '0.01' => 1,
        ];
        $this->assertSame($coinsChange, $purchasedItem->getChange());
    }

    public function test_when_pay_enough_for_buy(): void
    {
        $itemCount = 2;
        $amount = 10.0;
        $transaction = new PurchaseTransaction($itemCount, $amount);
        $purchasedItem = $this->machine->execute($transaction);

        $this->assertSame(2, $purchasedItem->getItemQuantity());
        $this->assertSame(9.98, $purchasedItem->getTotalAmount());
        $coinsChange = [
            '0.05' => 0,
            '0.02' => 1,
            '0.01' => 0,
        ];
        $this->assertSame($coinsChange, $purchasedItem->getChange());
    }
}
