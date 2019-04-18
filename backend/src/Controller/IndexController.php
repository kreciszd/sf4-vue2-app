<?php

namespace App\Controller;

use App\Message\ImportBeerData;
use OldSound\RabbitMqBundle\RabbitMq\Producer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(MessageBusInterface $bus, Producer $importDataProducer)
    {
        $data = ['status' => 'start'];

        // Symfony Messenger way
        $bus->dispatch(new ImportBeerData($data));

        // RabbitMQBundle Way
        $importDataProducer->publish(serialize($data));
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
}
