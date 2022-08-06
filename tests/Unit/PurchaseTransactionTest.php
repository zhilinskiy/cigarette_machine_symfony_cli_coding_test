<?php

namespace Tests\Unit;

use App\Machine\PurchaseTransaction;
use PHPUnit\Framework\TestCase;


/**
 * @covers PurchaseTransaction
 */
class PurchaseTransactionTest extends TestCase
{

    public function test_get_paid_amount_and_item_quantity()
    {
        $itemCount = 1;
        $amount = 10.0;

        $transaction = new PurchaseTransaction($itemCount, $amount);

        $this->assertSame($itemCount, $transaction->getItemQuantity());
        $this->assertSame($amount, $transaction->getPaidAmount());
    }

}
