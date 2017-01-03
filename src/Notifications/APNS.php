<?php

namespace NotificationChannels\AwsSns\Notifications;

class APNS
{
    /** @var array */
    protected $message = [];

    /** @var array */
    protected $customPayload = [];

    /**
    * @param string|array $alert    APNS message content.
     */
    public function __construct($alert = '')
    {
        $this->message['alert'] = $alert;
    }

    /**
     * Set alert message
     *
     * @param string|array $alert  Alert message content
     *
     * @return $this
     */
    public function message($alert)
    {
        $this->message['alert'] = $alert;

        return $this;
    }

    /**
     * Set badge count of app icon
     *
     * @param int $padge  Badge count
     *
     * @return $this
     */
    public function badge($badge)
    {
        $this->message['badge'] = $badge;

        return $this;
    }

    /**
     * Set alert message sound
     *
     * @param string $sound  System file sound
     *
     * @return $this
     */
    public function sound($sound)
    {
        $this->message['sound'] = $sound;

        return $this;
    }

    /**
     * Add object to custom payload
     *
     * @param string $key  Custompayload key
     * @param mixed $value Custompayload value
     *
     * @return $this
     */
    public function addCustomPayload($key, $value)
    {
        if($key){
            $this->customPayload[$key] = $value;
        }

        return $this;
    }

    /**
     * Get message in array format
     *
     * @return array
     */
    public function toArray()
    {
        $apnsMessage = [];

        $apnsMessage['aps'] = $this->message;

        if(!empty($this->customPayload)){
            $apnsMessage = array_merge($apnsMessage, $this->customPayload);
        }

        return $apnsMessage;
    }

    /**
     * Get message in JSON format
     *
     * @return string JSON object
     */
    public function toJSON()
    {
        return json_encode($this->toArray());
    }
}
