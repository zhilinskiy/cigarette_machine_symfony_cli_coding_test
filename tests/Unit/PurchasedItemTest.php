<?php
declare(strict_types=1);

namespace Tests\Unit;

use App\Machine\PurchasedItem;
use PHPUnit\Framework\TestCase;

class PurchasedItemTest extends TestCase
{

    public function test_purchased_item_can_be_created(): void
    {
        $itemQuantity = 3;
        $totalAmount = 3.99;
        $change = [];

        $purchasedItem = new PurchasedItem($itemQuantity, $totalAmount, $change);

        $this->assertSame($itemQuantity, $purchasedItem->getItemQuantity());
        $this->assertSame($totalAmount, $purchasedItem->getTotalAmount());
        $this->assertSame($change, $purchasedItem->getChange());
    }
}
