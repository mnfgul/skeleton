<?php

namespace NotificationChannels\AwsSns;

use NotificationChannels\AwsSns\Exceptions\CouldNotSendNotification;
use NotificationChannels\AwsSns\Events\MessageWasSent;
use NotificationChannels\AwsSns\Events\SendingMessage;
use Illuminate\Notifications\Notification;

class SNSChannel
{
    public function __construct()
    {
        // Initialisation code here
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\AwsSns\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        //$response = [a call to the api of your notification send]

//        if ($response->error) { // replace this by the code need to check for errors
//            throw CouldNotSendNotification::serviceRespondedWithAnError($response);
//        }
    }
}
