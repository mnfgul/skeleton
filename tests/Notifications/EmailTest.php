<?php

namespace NotificationChannels\AwsSns\Test;

use NotificationChannels\AwsSns\Notifications\Email;

class EmailTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_accepts_message_when_constructed()
    {
        $emailMessage = new Email('Email custom message');
        $this->assertEquals('Email custom message', $emailMessage->getMessage());
    }
}
