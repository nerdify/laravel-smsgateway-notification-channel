# SMS Gateway notifications channel for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nerdify/laravel-smsgateway-notification-channel.svg?style=flat-square)](https://packagist.org/packages/nerdify/laravel-smsgateway-notification-channel)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![StyleCI](https://styleci.io/repos/73677449/shield)](https://styleci.io/repos/73677449)

This package makes it easy to send notifications using [SMS Gateway](https://smsgateway.me/sms-api-documentation/getting-started) with Laravel.

## Contents

- [Requirements](#requirements)
- [Installation](#installation)
	- [Setting up your SMS Gateway account](#setting-up-your-sms-gateway-account)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
- [License](#license)

## Requirements
[Sign up](https://smsgateway.me/admin/users/login#signup) for a online sms gateway account.

## Installation

You can install the package via composer:

``` bash
composer require nerdify/laravel-smsgateway-notification-channel
```

You must install the service provider:

```php
// config/app.php
'providers' => [
    ...
    Nerdify\SmsGateway\SmsGatewayServiceProvider::class,
],
```

### Setting up your SMS Gateway account

Add your SMS Gateway email, password, and device ID to your `config/services.php`:

```php
// config/services.php
...
'smsgateway' => [
    'email' => env('SMSGATEWAY_EMAIL'),
    'password' => env('SMSGATEWAY_PASSWORD'),
    'device' => env('SMSGATEWAY_DEVICE'),
],
...
```

## Usage

You can use the channel in your `via()` method inside the notification:

``` php
use Illuminate\Notifications\Notification;
use Nerdify\SmsGateway\SmsGatewayChannel;
use Nerdify\SmsGateway\SmsGatewayMessage;

class InvoicePaid extends Notification
{
    public function via($notifiable)
    {
        return [SmsGatewayChannel::class];
    }

    public function toSmsGateway($notifiable)
    {
        return (new SmsGatewayMessage)
            ->content('Your invoice has been paid!');
    }
}
```

When sending notifications, the notification system will automatically look for a phone_number attribute on the notifiable entity. If you would like to customize the phone number the notification is delivered to, define a `routeNotificationForSmsGateway` method on the entity:

```php
public function routeNotificationForSmsGateway()
{
    return '+1234567890';
}
```

### Available Message methods

#### SmsGatewayMessage

- `content()`: The content of the message to be sent.
- `expiresAt()`: Time to give up trying to send the message at in Unix Time format.
- `sendAt()`: Time to send the message in Unix Time format.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
