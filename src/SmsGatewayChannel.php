<?php

namespace Nerdify\SmsGateway;

use Illuminate\Notifications\Notification;

class SmsGatewayChannel
{
    /**
     * The client instance.
     *
     * @var SmsGatewayClient
     */
    protected $client;

    /**
     * Create a new SMS Gateway channel instance.
     *
     * @param SmsGatewayClient $client
     */
    public function __construct(SmsGatewayClient $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed        $notifiable
     * @param Notification $notification
     *
     * @return array|void
     */
    public function send($notifiable, Notification $notification)
    {
        $to = $this->getTo($notifiable);

        $message = $notification->toSmsGateway($notifiable);

        if (is_string($message)) {
            $message = new SmsGatewayMessage($message);
        }

        return $this->client->send($this->buildParams($message, $to));
    }

    /**
     * Get phone number.
     *
     * @param $notifiable
     *
     * @return mixed
     */
    protected function getTo($notifiable)
    {
        if ($to = $notifiable->routeNotificationFor('smsGateway')) {
            return $to;
        }

        return $notifiable->phone_number;
    }

    /**
     * Build up params.
     *
     * @param SmsGatewayMessage $message
     * @param string            $to
     *
     * @return array
     */
    protected function buildParams(SmsGatewayMessage $message, $to)
    {
        $optionalFields = array_filter([
            'expires_at' => data_get($message, 'expiresAt'),
            'send_at'    => data_get($message, 'sendAt'),
        ]);

        return array_merge([
            'number'     => $to,
            'message'    => trim($message->content),
        ], $optionalFields);
    }
}
