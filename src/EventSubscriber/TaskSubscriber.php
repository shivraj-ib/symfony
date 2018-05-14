<?php
/**
 * Description of TaskSubscriber
 *
 * @author shivraj
 */
namespace App\EventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Event\TaskCreatedEvent;
use Psr\Log\LoggerInterface;


class TaskSubscriber implements EventSubscriberInterface
{
    
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    
    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return array(
           TaskCreatedEvent::NAME => array(
               array('logTask', 0)
           )
        );
    }

    public function logTask(TaskCreatedEvent $event)
    {
        $task = $event->getTask();
        //play with $task object
        //PALY WITH $TASK OBJECT
         $this->logger->info('NEW TASK ADDED : '. $task->getTitle());
    }   
}
