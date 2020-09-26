<?php

namespace MichaelDzjap\TwoFactorAuth\Providers;

use MichaelDzjap\TwoFactorAuth\Contracts\Token;
use MichaelDzjap\TwoFactorAuth\Contracts\TwoFactorProvider;

class NullProvider extends BaseProvider implements TwoFactorProvider, Token
{
    /**
     * {@inheritdoc}
     */
    public function register($user): void
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function unregister($user)
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function verify($user, string $token)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function sendToken($user, $otherParams): void
    {
        //
    }
}
