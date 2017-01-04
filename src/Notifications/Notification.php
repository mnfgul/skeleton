<?php

namespace NotificationChannels\AwsSns\Notifications;

abstract class Notification
{
    /** @var array */
    protected $message = [];

    /**
     * @param string|array $message Message content
     */
    public function __construct($message = '')
    {
        $this->message = $message;
    }

    /**
     * Set notification message.
     *
     * @param string|array $alert Notification message content
     *
     * @return $this
     */
    public function message($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get notification message.
     *
     * @return string|array $message  Notification message content
     */
    public function getMessage()
    {
        return $this->message;
    }
}
