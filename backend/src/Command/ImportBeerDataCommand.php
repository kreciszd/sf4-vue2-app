<?php

namespace App\Command;

use App\Entity\Beer;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportBeerDataCommand extends Command
{
    protected static $defaultName = 'import:beer-data';

    private $entityManager;
    private $logger;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Import information about beers from external API');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $io = new SymfonyStyle($input, $output);
        $client = new Client(['base_uri' => 'http://ontariobeerapi.ca']);

        try {
            $products = $client->get('/products')->getBody()->getContents();

            $batchSize = 20;
            $i = 0;
            foreach (json_decode($products) as $apiBeer) {
                $beer = $this->entityManager->getRepository(Beer::class)->findOneBy(['name' => $apiBeer->name]);

                if(!$beer) {
                    $beer = $this->entityManager->getRepository(Beer::class)->createNewBeer($apiBeer);
                    $this->entityManager->persist($beer);

                    if (($i % $batchSize) === 0) {
                        $this->entityManager->flush();
                        $this->entityManager->clear();
                    }
                    $i++;
                    $io->text('Added new beer to create: ' . $apiBeer->name);
                }
            }
            $this->entityManager->flush();
            $this->logger->notice('Success with import');
            $this->logger->info('Added new beers:'. $i);

            $io->success('Success with import.');

        } catch (\GuzzleHttp\Exception\ClientException $exception) {
            $io->error($exception->getMessage());
            $this->logger->error($exception->getMessage());

        } catch (\Exception $exception) {
            $io->error($exception->getMessage());
            $this->logger->error($exception->getMessage());
        }
    }
}
