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
     * @param mixed                                  $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\AwsSns\Exceptions\CouldNotSendNotification
     *
     * @return array
     */
    public function send($notifiable, Notification $notification)
    {
        $snsMessage = $notification->toSNS($notifiable);

        try {
            $response = $this->sns->publish($snsMessage->toArray());

            return $response;
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
