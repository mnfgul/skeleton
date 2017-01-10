<?php

namespace NotificationChannels\AwsSns\Test;

use NotificationChannels\AwsSns\Notifications\APNS;

class APNSTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_accepts_message_when_constructed()
    {
        $apnsMessage = new APNS('AWS custom message');
        $this->assertEquals('AWS custom message', $apnsMessage->getMessage());
    }

    /** @test */
    public function it_can_return_message_as_array()
    {
        $apnsMessage = new APNS();
        $apnsMessage->message('custom apns message');
        $apnsMessage->badge(10);
        $apnsMessage->sound('soundfile');
        $apnsMessage->addCustomPayload('custom_key_1', 'custom_value_1');
        $apnsMessage->addCustomPayload('custom_key_2', 'custom_value_2');

        $expected = [
            'aps' => [
                'alert' => 'custom apns message',
                'badge' => 10,
                'sound' => 'soundfile',
            ],
            'custom_key_1' => 'custom_value_1',
            'custom_key_2' => 'custom_value_2',
        ];
        $this->assertEquals($expected, $apnsMessage->toArray());
    }
}
