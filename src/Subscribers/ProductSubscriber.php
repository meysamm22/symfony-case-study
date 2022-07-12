<?php


namespace App\Subscribers;


use App\Events\ProductCreatedEvent;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class ProductSubscriber implements EventSubscriberInterface
{

    private  LoggerInterface $logger;
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return [
          ProductCreatedEvent::NAME => 'onProductCreated'
        ];
    }

    public function onProductCreated(ProductCreatedEvent $event){

        $this->logger->info("The event received");
    }
}