<?php

namespace Tests\Feature;

use App\Command\PurchaseCigarettesCommand;
use PHPUnit\Framework\TestCase as BaseTesCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class PurchaseCigarettesTestCase extends BaseTesCase
{
    /** @var CommandTester */
    protected $commandTester;

    protected function setUp(): void
    {
        $application = new Application();
        $application->add(new PurchaseCigarettesCommand('purchase-cigarettes'));
        $command = $application->find('purchase-cigarettes');
        $this->commandTester = new CommandTester($command);
    }

    protected function tearDown(): void
    {
        $this->commandTester = null;
    }
}
