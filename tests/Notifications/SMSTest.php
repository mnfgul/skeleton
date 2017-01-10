<?php

namespace NotificationChannels\AwsSns\Test;

use NotificationChannels\AwsSns\Notifications\SMS;

class SMSTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_accepts_message_when_constructed()
    {
        $smsMessage = new SMS('SMS custom message');
        $this->assertEquals('SMS custom message', $smsMessage->getMessage());
    }
}
