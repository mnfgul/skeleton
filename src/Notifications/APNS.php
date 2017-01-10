<?php

namespace NotificationChannels\AwsSns\Notifications;

class APNS extends Notification
{
    /** @var array */
    protected $apnsNotification = [];

    /** @var array */
    protected $customPayload = [];

    /**
     * Set badge count of app icon.
     *
     * @param int $padge Badge count
     *
     * @return $this
     */
    public function badge($badge)
    {
        $this->apnsNotification['badge'] = $badge;

        return $this;
    }

    /**
     * Set alert message sound.
     *
     * @param string $sound System file sound
     *
     * @return $this
     */
    public function sound($sound)
    {
        $this->apnsNotification['sound'] = $sound;

        return $this;
    }

    /**
     * Add object to custom payload.
     *
     * @param string $key   Custompayload key
     * @param mixed  $value Custompayload value
     *
     * @return $this
     */
    public function addCustomPayload($key, $value)
    {
        if ($key) {
            $this->customPayload[$key] = $value;
        }

        return $this;
    }

    /**
     * Get message in array format.
     *
     * @return array
     */
    public function toArray()
    {
        $apnsMessage = [];
        $this->apnsNotification['alert'] = $this->getMessage();

        $apnsMessage['aps'] = $this->apnsNotification;

        if (! empty($this->customPayload)) {
            $apnsMessage = array_merge($apnsMessage, $this->customPayload);
        }

        return $apnsMessage;
    }

    /**
     * Get message in JSON format.
     *
     * @return string JSON object
     */
    public function toJSON()
    {
        return json_encode($this->toArray());
    }
}
