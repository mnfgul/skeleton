<?php

namespace NotificationChannels\AwsSns;

use Aws\Sns\Message;

class SNSMessage
{
    /** @var string */
    protected $message;

    /** @var string */
    protected $subject;

    /** @var string */
    protected $topicArn;

    /** @var string */
    protected $targetArn;

    /** @var string */
    protected $messageStructure = 'json';

    /** @var array */
    protected $messageAttributes;

    /** @var string */
    protected $phoneNumber;

    /**
     * @param string $message
     */
    public function __construct($message = '')
    {
        $this->message = $message;
    }

    /**
     * Set the message content.
     *
     * @param string $value
     *
     * @return $this
     */
    public function message($value)
    {
        $this->message = $value;

        return $this;
    }

    /**
     * Set the message subject. Required only for email messages.
     *
     * @param string $value
     *
     * @return $this
     */
    public function subject($value)
    {
        $this->subject = $value;

        return $this;
    }

    /**
     * Set topic ARN.
     *
     * @param string $value
     *
     * @return $this
     */
    public function topicArn($value)
    {
        $this->topicArn = $value;

        return $this;
    }

    /**
     * Set target ARN.
     *
     * @param string $value
     *
     * @return $this
     */
    public function targetArn($value)
    {
        $this->targetArn = $value;

        return $this;
    }

    /**
     * Set message attributes.
     *
     * @param string $array
     *
     * @return $this
     */
    public function messageAttributes($arr)
    {
        $this->messageAttributes = $arr;

        return $this;
    }

    /**
     * Set the message structure. Raw or JSON(default) are the supported structures.
     *
     * @param string $value
     *
     * @return $this
     */
    public function messageStructure($value = 'json')
    {
        $this->messageStructure = $value;

        return $this;
    }

    /**
     * Set phone number for SMS messages.
     *
     * @param string $value
     *
     * @return $this
     */
    public function phoneNumber($value)
    {
        $this->phoneNumber = $value;

        return $this;
    }

    /**
     * Get message in array format for SNS
     *
     * @return array
     */
    public function toArray()
    {
        $message = [
            'Message' => $this->message,
            'Subject' => $this->subject,
            //'MessageStructure' => $this->messageStructure,
        ];

        if ($this->topicArn) {
            $message['TopicArn'] = $this->topicArn;
        }

        if ($this->targetArn) {
            $message['TargetArn'] = $this->targetArn;
        }

        if ($this->phoneNumber) {
            $message['PhoneNumber'] = $this->phoneNumber;
        }

        if ($this->messageAttributes) {
            $message['messageAttributes'] = $this->messageAttributes;
        }

        return $message;
    }


    //Publish/send message to the endpoint
    /*
		$jsonMessage = '{
			"default": "Hi my friend",
			"APNS": "{\"aps\":{\"alert\": \"Hi my friend\"} }",
			"APNS_SANDBOX":"{\"aps\":{\"alert\":\"Hi my friend\"}}",
			"GCM": "{ \"data\": { \"message\": \"Hi my friend\" } }"
			}';
    */
}
