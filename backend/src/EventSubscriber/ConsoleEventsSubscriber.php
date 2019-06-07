<?php

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ConsoleEventsSubscriber implements EventSubscriberInterface
{
    private $logger;

    public function __construct(LoggerInterface $importerLogger)
    {
        $this->logger = $importerLogger;
    }

    public function onConsoleError(ConsoleErrorEvent $event)
    {
        $this->logger->error('Message: '.$event->getError()->getMessage(), [
            'Code:' => $event->getError()->getCode(),
            'Line:' => $event->getError()->getLine(),
        ]);
    }

    public static function getSubscribedEvents(): array
    {
        return ['console.error' => 'onConsoleError'];
    }
}
