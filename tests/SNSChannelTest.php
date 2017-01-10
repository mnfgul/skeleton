<?php

namespace NotificationChannels\AwsSns\Test;

use Mockery;
use Aws\Sns\SnsClient;
use Illuminate\Notifications\Notification;
use NotificationChannels\AwsSns\SNSChannel;
use NotificationChannels\AwsSns\SNSMessage;

class SNSChannelTest extends \PHPUnit_Framework_TestCase
{
    /** @var Aws\Sns\SnsClient $snsClient */
    protected $snsClient;

    /** @var NotificationChannels\AwsSns\SNSChannel $snsChannel */
    protected $snsChannel;

    public function setUp()
    {
        parent::setUp();
        $this->snsClient = Mockery::mock(SnsClient::class);
        $this->snsChannel = new SNSChannel($this->snsClient);
    }

    /** @test */
    public function it_can_send_a_notification()
    {
        $this->snsClient
            ->shouldReceive('publish')
            ->once()
            ->andReturn(true);
        $result = $this->snsChannel->send(new TestNotifiable(), new TestNotification());

        $this->assertTrue($result);
    }
}

class TestNotifiable
{
    use \Illuminate\Notifications\Notifiable;

    /**
     * @return int
     */
    public function routeNotificationForSns()
    {
        return false;
    }
}

class TestNotification extends Notification
{
    public function toSNS($notifiable)
    {
        return (new SNSMessage())
                ->message('This is a simple message')
                ->subject('This is subject')
                ->topicArn('<topicArn>');
    }
}
