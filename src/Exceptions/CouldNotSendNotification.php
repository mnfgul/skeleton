<?php

namespace NotificationChannels\AwsSns\Exceptions;

use Exception;

class CouldNotSendNotification extends Exception
{
    /**
     * @param \Aws\Sns\Exception $response
     *
     * @return static
     */
    public static function connectionFailed(Exception $exception)
    {
        return new static("Could not connect to the AWS. {$exception->getAwsErrorCode()}: {$exception->getMessage()}");
    }

    /**
     * @param \Aws\Sns\Exception $response
     *
     * @return static
     */
    public static function invalidParameter(Exception $exception)
    {
        return new static("A request parameter or its value does not comply with the associated constraints. {$exception->getAwsErrorCode()}: {$exception->getMessage()}");
    }

    /**
     * @param \Aws\Sns\Exception $response
     *
     * @return static
     */
    public static function notAuthorized(Exception $exception)
    {
        return new static("The user has been denied to access the requested resource. {$exception->getAwsErrorCode()}: {$exception->getMessage()}");
    }

    /**
     * @param \Aws\Sns\Exception $response
     *
     * @return static
     */
    public static function serviceRespondedWithAnError($response)
    {
        return new static("Service responded with an error. {$exception->getAwsErrorCode()}: {$exception->getMessage()}");
    }
}
