<?php

namespace App\Command;

use App\Services\LoadCryptoDataService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'rates:load:newest',
    description: 'Load crypto rates from binance to newest',
)]
class LoadCryptoRatesToNewestCommand extends Command
{
    public function __construct(
        private readonly LoadCryptoDataService $cryptoDataService
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->cryptoDataService->loadDataToNewest();

        return Command::SUCCESS;
    }
}
