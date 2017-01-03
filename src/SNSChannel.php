<?php

namespace NotificationChannels\AwsSns;

use App;
use Exception;
use NotificationChannels\AwsSns\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;

class SNSChannel
{
    private $sns;

    public function __construct()
    {
        $this->sns = App::make('aws')->createClient('sns');
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
        $snsMessage = $notification->toSNS($notifiable);
        print_r($snsMessage->toArray());die();
        try {
            var_dump($snsMessage->toArray());
            $result = $this->sns->publish($snsMessage->toArray());
            //var_dump($result);
        } catch (Exception $exception) {

            if ($exception->isConnectionError()) {
                throw CouldNotSendNotification::connectionFailed($exception);
            }

            switch ($exception->getAwsErrorCode()) {
                case 'InvalidParameterException' || 'InvalidParameterValueException':{
                    throw CouldNotSendNotification::invalidParameter($exception);
                }break;

                case 'AuthorizationErrorException':{
                    throw CouldNotSendNotification::notAuthorized($exception);
                }break;

                default:{
                    throw CouldNotSendNotification::serviceRespondedWithAnError($exception);
                }
            }
        }
    }
}
