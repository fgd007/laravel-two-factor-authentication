<?php

namespace MichaelDzjap\TwoFactorAuth\Contracts;

interface SMSToken
{
    /**
     * Send a user a two-factor authentication token via SMS.
     *
     * @param mixed $user
     * @param null $otherParams
     * @return void
     */
    public function sendSMSToken($user, $otherParams): void;
}
