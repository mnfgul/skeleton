<?php

namespace NotificationChannels\AwsSns\Exceptions;

use Exception;

class InvalidNotificationFormat extends Exception
{
    /**
     * @return static
     */
    public static function multipleEndPoints()
    {
        return new static('Can not setup multiple endpoints. Set only one of these endpoints; TopicArn, TargetArn, PhoneNumber');
    }

    /**
     * @return static
     */
    public static function invalidMessageStructure()
    {
        return new static('Message structure need to be "json" for custom messages.');
    }
}
