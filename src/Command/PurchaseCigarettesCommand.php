<?php

namespace App\Command;

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
     * @param InputInterface   $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $itemCount = (int) $input->getArgument('packs');
        $amount = (float) \str_replace(',', '.', $input->getArgument('amount'));


        // $cigaretteMachine = new CigaretteMachine();
        // ...

        $output->writeln('You bought <info>...</info> packs of cigarettes for <info>...</info>, each for <info>...</info>. ');
        $output->writeln('Your change is:');

        $table = new Table($output);
        $table
            ->setHeaders(array('Coins', 'Count'))
            ->setRows(array(
                // ...
                array('0.02', '0'),
                array('0.01', '0'),
            ))
        ;
        $table->render();

        return Command::SUCCESS;
    }
}
