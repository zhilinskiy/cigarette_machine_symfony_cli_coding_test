<?php
declare(strict_types=1);

namespace App\Command;

use App\Machine\CigaretteMachine;
use App\Machine\PurchaseTransaction;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CigaretteMachine
 * @package App\Command
 */
class PurchaseCigarettesCommand extends Command
{
    // the command description shown when running "php bin/console list"
    protected static $defaultDescription = 'Purchase cigarettes';

    /**
     * @return void
     */
    protected function configure(): void
    {
        // the command help shown when running the command with the "--help" option
        $this->setHelp('This command allows you to purchase cigarettes');
        $this->addArgument('packs', InputArgument::REQUIRED, "How many packs do you want to buy?");
        $this->addArgument('amount', InputArgument::REQUIRED, "The amount in euro.");
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $itemCount = (int)$input->getArgument('packs');
        $amount = (float)\str_replace(',', '.', (string)$input->getArgument('amount'));
        if ($itemCount < 1) {
            $output->writeln('Packs amount should be 1 or more');

            return Command::FAILURE;
        }
        if ($amount <= 0) {
            $output->writeln('Money amount should be more than 0');

            return Command::FAILURE;
        }


        $cigaretteMachine = new CigaretteMachine();
        $transaction = new PurchaseTransaction($itemCount, $amount);
        $purchase = $cigaretteMachine->execute($transaction);

        $summary = 'You bought <info>%d</info> packs of cigarettes for <info>-%.2F€</info>, each for <info>-%.2F€</info>.';
        $output->writeln(sprintf(
            $summary,
            $purchase->getItemQuantity(),
            $purchase->getTotalAmount(),
            CigaretteMachine::ITEM_PRICE,
        ));
        $output->writeln('Your change is:');

        $table = new Table($output);
        $table->setHeaders(['Coins', 'Count']);
        foreach ($purchase->getChange() as $coin => $amount) {
            $table->addRow([$coin, $amount]);
        }
        $table->render();

        return Command::SUCCESS;
    }
}
