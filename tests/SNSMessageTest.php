<?php

namespace NotificationChannels\AwsSns\Test;

use NotificationChannels\AwsSns\SNSMessage;
use NotificationChannels\AwsSns\Exceptions\InvalidNotificationFormat;

class SNSMessageTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_accepts_message_when_constructed()
    {
        $message = new SNSMessage('AWS SNS notification message for constructor');
        $this->assertEquals('AWS SNS notification message for constructor', $message->toArray()['Message']);
    }

    /** @test */
    public function it_does_not_accept_multiple_endpoints()
    {
        $this->setExpectedException(InvalidNotificationFormat::class);
        $message = new SNSMessage();
        $message->topicArn('<topicArn>');
        $message->targetArn('<targetArn>');
        $message->targetArn('<phoneNumber>');
    }

    /** @test */
    public function it_set_string_message_for_default()
    {
        $message = new SNSMessage();
        $message->message('message');
        $this->assertTrue(is_string($message->toArray()['Message']));
    }

    /** @test */
    public function it_set_json_message_for_json()
    {
        $message = new SNSMessage();
        $message->message('message');
        $message->messageStructure('json');
        $this->assertEquals(
            json_encode(['default' => 'message']),
            $message->toArray()['Message']
        );
    }

    /** @test */
    public function it_can_return_message_as_array()
    {
        $message = new SNSMessage();
        $message->message('message');
        $message->subject('subject');
        $message->topicArn('topicArn');
        $message->messageStructure('json');
        $message->messageAttributes(['key' => 'value']);

        $expected = [
            'Subject' => 'subject',
            'TopicArn' => 'topicArn',
            'MessageStructure' => 'json',
            'MessageAttributes' => [
                'key' => 'value',
            ],
            'Message' => json_encode(['default' => 'message']),
            ];
        $this->assertEquals($expected, $message->toArray());
    }
}
