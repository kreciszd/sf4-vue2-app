<?php

namespace App\Controller;

use App\Message\ImportBeerData;
use OldSound\RabbitMqBundle\RabbitMq\Producer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param MessageBusInterface $bus
     * @param Producer $importDataProducer
     * @return Response
     */
    public function index(
        MessageBusInterface $bus,
        Producer $importDataProducer
    ): Response {

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
