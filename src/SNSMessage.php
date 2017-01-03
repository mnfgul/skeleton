<?php

namespace NotificationChannels\AwsSns;

use Aws\Sns\Message;
use NotificationChannels\AwsSns\Notifications\APNS;
use NotificationChannels\AwsSns\Notifications\GCM;

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
    protected $messageStructure;

    /** @var array */
    protected $messageAttributes;

    /** @var string */
    protected $phoneNumber;

    /** @var NotificationChannels\AwsSns\Notifications\APNS */
    protected $apnsMessage;

    /** @var NotificationChannels\AwsSns\Notifications\APNS */
    protected $apnsSandboxMessage;

    /** @var NotificationChannels\AwsSns\Notifications\GCM */
    protected $gcmMessage;

    /**
     * @param string $message
     */
    public function __construct($message = '')
    {
        $this->message = $message;
    }

    /**
     * Set the default message content.
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
     * Set custom message for APNS
     *
     * @param NotificationChannels\AwsSns\Notifications\APNS $apnsMessage  APNS message.
     *
     * @return $this
     */
    public function apnsMessage(APNS $apnsMessage)
    {
        $this->apnsMessage = $apnsMessage;

        return $this;
    }

    /**
     * Set custom message for GCM
     *
     * @param NotificationChannels\AwsSns\Notifications\GCM $gcmMessage  GCM message.
     *
     * @return $this
     */
    public function gcmMessage(GCM $gcmMessage)
    {
        $this->gcmMessage = $gcmMessage;

        return $this;
    }

    /**
     * Get message in array format for SNS
     *
     * @return array
     */
    public function toArray()
    {
        $message = [];

        if($this->messageStructure == 'json'){
            $jsonMessage = [];
            $jsonMessage['default'] = $this->message;

            // APNS Custom Message
            if(isset($this->apnsMessage)){
                $jsonMessage['APNS'] = $this->apnsMessage->toJSON();
            }

            if(isset($this->apnsSandboxMessage)){
                $jsonMessage['APNS_SANDBOX'] = $this->apnsSandboxMessage;
            }

            // GCM Custom Message
            if(isset($this->gcmMessage)){
                $jsonMessage['GCM'] = $this->gcmMessage->toJSON();
            }

            $message['Message'] = json_encode($jsonMessage); // TODO: escape fix

        }else{
            $message['Message'] = $this->message;
        }

        $message['Subject'] = $this->subject;

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
    
}
