<?php

namespace MichaelDzjap\TwoFactorAuth\Contracts;

interface Token
{
    /**
     * Send a user a two-factor authentication token via SMS.
     *
     * @param mixed $user
     * @param null $otherParams
     * @return void
     */
    public function sendToken($user, $otherParams): void;
}
