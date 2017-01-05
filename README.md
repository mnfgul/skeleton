# AWS SNS Notification Channel For Laravel 5.3

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/aws-sns.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/aws-sns)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/laravel-notification-channels/aws-sns/master.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/aws-sns)
[![StyleCI](https://styleci.io/repos/:style_ci_id/shield)](https://styleci.io/repos/:style_ci_id)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/:sensio_labs_id.svg?style=flat-square)](https://insight.sensiolabs.com/projects/:sensio_labs_id)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/aws-sns.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/aws-sns)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/laravel-notification-channels/aws-sns/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/aws-sns/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/aws-sns.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/aws-sns)

This package makes it easy to send notifications using [Amazon Simple Notification Service (Amazon SNS)](https://aws.amazon.com/sns/) with Laravel 5.3.


## Contents

- [Installation](#installation)
	- [Setting up the SNS service](#setting-up-the-SNS-service)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

Install this package with Composer:

`composer require laravel-notification-channels/aws-sns`

After installing the package, register the ServiceProvider with your config/app.php.

`NotificationChannels\AwsSns\SNSServiceProvider::class`


### Setting up the AWS SNS service

You will need to obtain required API access key and secret key from AWS console. Also, you need to define the region that you are using for SNS.

```
AWS_ACCESS_KEY_ID
AWS_SECRET_ACCESS_KEY
AWS_REGION (default = us-east-1)
```
If you need to override other settings for AWS API access, please refer to configuration section of official [AWS PHP Laravel Service Provider](#https://github.com/aws/aws-sdk-php-laravel) which this package depends on.

## Usage

In order to send notifications via SNS, you need to create a notification class. If you want to send message to a specific endpoint, you need to provide TargetArn. If you want to send to a topic, then provide TopicArn. A simple example is as follow:

```
use Illuminate\Notifications\Notification;
use NotificationChannels\AwsSns\SNSMessage;
use NotificationChannels\AwsSns\SNSChannel;
use NotificationChannels\AwsSns\Notifications\APNS;
use NotificationChannels\AwsSns\Notifications\GCM;
use NotificationChannels\AwsSns\Notifications\SMS;
use NotificationChannels\AwsSns\Notifications\Email;

class AccountApproved extends Notification
{

    public function via($notifiable)
    {
        return [SNSChannel::class];
    }

    public function toSNS($notifiable)
    {

        return (new SNSMessage)
                    ->message('This is a simple message')
                    ->subject('This is subject')
                    ->topicArn('<YourTopicArn>');
    }
}
```  

SNS support custom messages for specific endpoints. Therefore, you can setup a custom message for various platforms. For instance, you can configure a custom GCM push notification that will be send to the subscribers of the topic that are registered via GCM. Currently, APNS, GCM, SMS and Email are implemented. Other endpoints that are supported by AWS will be added later.

```
public function toSNS($notifiable)
{
    return (new SNSMessage())
                ->message('This is a custom message')
                ->subject('This is subject')
                ->messageStructure('json')
                ->topicArn('<TopicArn>')
                ->apnsMessage((new APNS)
                                ->message('APNS custom message')
                                ->badge(2)
                                ->sound('sound.mp3')
                                ->addCustomPayload('custom1', 'test value 1')
                                ->addCustomPayload('custom2', 'test value 2'))
                ->gcmMessage((new GCM)
                                ->message('GCM custom message'))
                ->smsMessage(new SMS('SMS custom message'))
                ->emailMessage(new Email('Email custom message'));
}

```

### Available methods

##### Methods of generic SNS notifications
- `subeject()`: Subject of the notification. Required for email notification endpoints.
- `message()`: Default message of the notification.
- `topicArn()`: Topic that notification will be send to.
- `targetArn()`: A specific target ARN, if you want to send notification to a specific subscriber.
- `messageStructure()`: If you want to use custom notifications for different endpoints, then you need to set message structure to `'json'`
- `messageAttributes()`: Custom attributes supported by AWS SNS.
- `phoneNumber()`: If you want to send SMS, set phone number.
- `apnsMessage()`: Custom APNS message.
- `gcmMessage()`: Custom GCM message.
- `smsMessage()`: Custom SMS message.
- `emailMessage()`: Custom Email message.

##### Methods of APNS notifications
- `message()`: APNS custom message.
- `badge()`: App icon badge count.
- `sound()`: Alert message sound.
- `addCustomPayload()`: Custom payload for notification.

##### Methods of GCM notifications
- `message()`: GCM custom message.
- `data()`: Data payload.
- `notification()`: Notification payload.
- `priority()`: Notification priority.
- `collapseKey()`: Notification collapse key.
- `timeToLive()`: Notification time to live duration.

##### Methods of SMS notifications
- `message()`: SMS custom message.

##### Methods of Email notifications
- `message()`: Email custom message.

For further details of each method, please refer to [SNS PHP SDK](#http://docs.aws.amazon.com/aws-sdk-php/v3/api/api-sns-2010-03-31.html#publish).

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email hi@menafgul.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Menaf Gul](https://github.com/:mnfgul)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
