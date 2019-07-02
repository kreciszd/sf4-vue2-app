<?php

namespace App\Command;

use App\Service\ImportBeerDataService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportBeerDataCommand extends Command
{
    protected static $defaultName = 'import:beer-data';

    /** @var ImportBeerDataService $importBeerDataService */
    private $importBeerDataService;

    /**
     * ImportBeerDataCommand constructor.
     * @param ImportBeerDataService $importBeerDataService
     */
    public function __construct(ImportBeerDataService $importBeerDataService)
    {
        $this->importBeerDataService = $importBeerDataService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Import information about beers from external API');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @throws ORMException
     * @throws OptimisticLockException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->text('Start import');
        $this->importBeerDataService->execute();
        $io->success('Success with import.');
    }
}
