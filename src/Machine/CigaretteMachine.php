<?php
declare(strict_types=1);

namespace App\Machine;

/**
 * Class CigaretteMachine
 * @package App\Machine
 */
class CigaretteMachine implements MachineInterface
{
    const ITEM_PRICE = 4.99;
    const COINS = [
        0.05,
        0.02,
        0.01,
    ];

    public function execute(PurchaseTransactionInterface $purchaseTransaction): PurchasedItem
    {
        $orderedItemsQuantity = $purchaseTransaction->getItemQuantity();
        $paidAmount = Money::fromFloat($purchaseTransaction->getPaidAmount());
        $itemQuantity = $this->calculateQuantity($orderedItemsQuantity, $paidAmount);
        $totalAmount = $this->calculateTotal($itemQuantity);
        $change = $this->calculateChange($paidAmount, $totalAmount);

        return new PurchasedItem($itemQuantity, $totalAmount->toFloat(), $change);
    }

    private function calculateQuantity(int $orderedItemsQuantity, MoneyInterface $paidAmount): int
    {
        $orderedItemsTotal = $this->calculateTotal($orderedItemsQuantity);
        if ($orderedItemsTotal->toCents() > $paidAmount->toCents()) {
           return $paidAmount->amount(Money::fromFloat(self::ITEM_PRICE));
        }

        return $orderedItemsQuantity;
    }

    private function calculateTotal(int $orderedItemsQuantity): MoneyInterface
    {
        return Money::fromFloat(self::ITEM_PRICE)
            ->mul($orderedItemsQuantity);
    }

    private function calculateChange(MoneyInterface $paidAmount, MoneyInterface $totalAmount): array
    {
        $coinsChange = [];
        $moneyChange = $paidAmount->sub($totalAmount);
        foreach (self::COINS as $coin) {
            $coin = Money::fromFloat($coin);
            $coinsAmount = $moneyChange->amount($coin);
            $moneyChange = $moneyChange->sub($coin->mul($coinsAmount));
            $coinsChange[$coin->toString()] = $coinsAmount;
        }
        return $coinsChange;
    }
}
