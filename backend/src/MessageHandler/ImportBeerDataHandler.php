<?php

namespace App\MessageHandler;

use App\Message\ImportBeerData;
use App\Service\ImportBeerDataService;
use DateTime;
use Exception;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ImportBeerDataHandler implements MessageHandlerInterface
{
    private $importBeerDataService;

    public function __construct(ImportBeerDataService $importBeerDataService)
    {
        $this->importBeerDataService = $importBeerDataService;
    }

    public function __invoke(ImportBeerData $content)
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