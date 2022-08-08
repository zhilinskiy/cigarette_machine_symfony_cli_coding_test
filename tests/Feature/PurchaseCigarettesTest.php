<?php
declare(strict_types=1);

namespace Tests\Feature;

use Symfony\Component\Console\Command\Command;

class PurchaseCigarettesTest extends PurchaseCigarettesTestCase
{
    public function test_that_command_return_error_when_packs_zero()
    {
        $this->assertTrue(true);
        $this->commandTester->execute(['packs' => 0, 'amount' => 1]);
        $this->assertSame(Command::FAILURE, $this->commandTester->getStatusCode());
    }

    public function test_that_command_return_error_when_amount_zero()
    {
        $this->assertTrue(true);
        $this->commandTester->execute(['packs' => 1, 'amount' => 0]);
        $this->assertSame(Command::FAILURE, $this->commandTester->getStatusCode());
    }

    public function test_that_command_return_success()
    {
        $this->assertTrue(true);
        $this->commandTester->execute(['packs' => 1, 'amount' => 5]);
        $this->commandTester->assertCommandIsSuccessful();
        $expectedOutput = 'You bought 1 packs of cigarettes for -4.99€, each for -4.99€.
Your change is:
+-------+-------+
| Coins | Count |
+-------+-------+
| 0.05  | 0     |
| 0.02  | 0     |
| 0.01  | 1     |
+-------+-------+
';
        $this->assertSame($expectedOutput, $this->commandTester->getDisplay());
    }
}
