<?php

namespace App\Consumer;

use App\Service\ImportBeerDataService;
use DateTime;
use Exception;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class ImportDataConsumer implements ConsumerInterface
{
    private $importBeerDataService;

    public function __construct(ImportBeerDataService $importBeerDataService)
    {
        $this->importBeerDataService = $importBeerDataService;
    }

    public function execute(AMQPMessage $msg)
    {
        try {
            var_dump('Start: ');
            var_dump((new DateTime())->format('H:i:s'));
            $status = $this->importBeerDataService->execute();
            var_dump('Finish:');
            var_dump((new DateTime())->format('H:i:s'));
            var_dump($status);

            return $status;
        }
        catch (Exception $exception) {
            return false;
        }
    }
}