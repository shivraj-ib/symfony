<?php

namespace App\EventListner;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\Event;
use Psr\Log\LoggerInterface;

class TaskCreatedEventListner
{
    
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    
    public function onTaskCreated(Event $event) {
         $task = $event->getTask();
         //PALY WITH $TASK OBJECT
         $this->logger->info('NEW TASK ADDED : '. $task->getTitle());             
    }
}