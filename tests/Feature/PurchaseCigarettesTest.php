<?php

namespace Tests\Feature;

class PurchaseCigarettesTest extends PurchaseCigarettesTestCase
{
    public function test_that_command_finished_without_errors()
    {
        $this->assertTrue(true);
        $this->commandTester->execute(['packs' => 0, 'amount' => 0]);
        $this->commandTester->assertCommandIsSuccessful();
    }
}
