<?php

namespace Nerdify\SmsGateway;

class SmsGatewayMessage
{
    /**
     * The message content.
     *
     * @var string
     */
    public $content;

    /**
     * Time to give up trying to send the message at.
     *
     * @var int
     */
    public $expiresAt;

    /**
     * @var int
     */
    public $sendAt;

    /**
     * Create a new message instance.
     *
     * @param string $content
     */
    public function __construct($content = '')
    {
        $this->content = $content;
    }

    /**
     * Create a new message instance.
     *
     * @param string $content
     */
    public static function create($content = '')
    {
        new static($content);
    }

    /**
     * Set the message content.
     *
     * @param string $content
     *
     * @return $this
     */
    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the message expires at.
     *
     * @param int $expiresAt
     *
     * @return $this
     */
    public function expiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    /**
     * Set the message send at.
     *
     * @param int $sendAt
     *
     * @return $this
     */
    public function sendAt($sendAt)
    {
        $this->sendAt = $sendAt;

        return $this;
    }
}
