<?php
namespace App\Tests\Service;

use App\Service\MessageGenerator;
use PHPUnit\Framework\TestCase;

class MessageGeneratorTest extends TestCase
{
    //test MessageGenerator service
    public function testRandomMessage(MessageGenerator $messageGenerator)
    {
        $message = $messageGenerator->getHappyMessage();

        // assert that your calculator added the numbers correctly!
        $messages = [
            'Message for you: You did it! You updated the system! Amazing!',
            'Message for you: That was one of the coolest updates I\'ve seen all day!',
            'Message for you: Great work! Keep going!',
        ];
        $this->assertContains( $message, $messages );
    }
}
