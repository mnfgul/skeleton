<?php

namespace NotificationChannels\AwsSns\Test;

use NotificationChannels\AwsSns\Notifications\GCM;

class GCMTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_accepts_message_when_constructed()
    {
        $gcmMessage = new GCM('GCM custom message');
        $this->assertEquals('GCM custom message', $gcmMessage->getMessage());
    }

    /** @test */
    public function it_can_return_message_as_array()
    {
        $gcmMessage = new GCM();
        $gcmMessage->message('custom gcm message');
        $gcmMessage->priority('normal');
        $gcmMessage->collapseKey('greeting friend');
        $gcmMessage->timeToLive(200);
        $gcmMessage->data(['score' => '1']);
        $gcmMessage->data(['status' => 'online']);
        $gcmMessage->notification('{\"body\" : \"hi!\",\"title\" : \"Greeting\",\"icon\" : \"myicon\"}');

        $expected = [
            'data' => [
                'message' => 'custom gcm message',
                'score' => '1',
                'status' => 'online',
            ],
            'priority' => 'normal',
            'collapse_key' => 'greeting friend',
            'time_to_live' => 200,
            'notification' => '{\"body\" : \"hi!\",\"title\" : \"Greeting\",\"icon\" : \"myicon\"}',
        ];
        $this->assertEquals($expected, $gcmMessage->toArray());
    }
}
