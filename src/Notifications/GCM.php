<?php

namespace NotificationChannels\AwsSns\Notifications;

class GCM extends Notification
{
    /** @var array */
    protected $gmcNotification = [];

    /** @var array */
    protected $data = [];

    /** @var array */
    protected $notification;

    /**
     * Set notification priority.
     *
     * @param string $priority
     *
     * @return $this
     */
    public function priority($priority)
    {
        $this->gmcNotification['priority'] = $priority;

        return $this;
    }

    /**
     * Set notification collapse key.
     *
     * @param string $collapseKey
     *
     * @return $this
     */
    public function collapseKey($collapseKey)
    {
        $this->gmcNotification['collapse_key'] = $collapseKey;

        return $this;
    }

    /**
     * Set notification time to live.
     *
     * @param int $timeToLive
     *
     * @return $this
     */
    public function timeToLive($timeToLive)
    {
        $this->gmcNotification['time_to_live'] = $timeToLive;

        return $this;
    }

    /**
     * Set GCM message data payload.
     *
     * @param array $data Data payload array
     *
     * @return $this
     */
    public function data($data)
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    /**
     * Set GMC notification payload.
     *
     * @param array $notification Notification object
     *
     * @return $this
     */
    public function notification($notification)
    {
        $this->notification = $notification;

        return $this;
    }

    /**
     * Get message in array format.
     *
     * @return array
     */
    public function toArray()
    {
        // append data and notification payloads
        $this->data['message'] = $this->getMessage();
        $this->gmcNotification['data'] = $this->data;

        if (! empty($this->notification)) {
            $this->gmcNotification['notification'] = $this->notification;
        }

        return $this->gmcNotification;
    }

    /**
     * Get message in json format.
     *
     * @return string JSON object
     */
    public function toJSON()
    {
        return json_encode($this->toArray());
    }
}
