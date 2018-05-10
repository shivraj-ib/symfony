<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MessageGenerator
 *
 * @author shivraj
 */
namespace App\Service;
use Psr\Log\LoggerInterface;

class MessageGenerator
{
    private $logger;
    private $msgPrefix;

    public function __construct(LoggerInterface $logger, $msgPrefix)
    {
        $this->logger = $logger;
        $this->msgPrefix = $msgPrefix;
    }
    
    public function getHappyMessage()
    {
        $messages = [
            'You did it! You updated the system! Amazing!',
            'That was one of the coolest updates I\'ve seen all day!',
            'Great work! Keep going!',
        ];        

        $index = array_rand($messages);
        
        $this->logger->info( $this->msgPrefix.": ".$messages[$index]);

        return $this->msgPrefix.": ".$messages[$index];
    }
}