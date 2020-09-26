<?php

namespace MichaelDzjap\TwoFactorAuth;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

trait TwoFactorAuthenticable
{
    /**
     * Get the mobile phone number associated with the user.
     *
     * Override in your User model to suit your application.
     *
     * @return array
     */
    public function getPhoneNumber($obfuscate = false): array
    {

        $phoneNumber = $this->mobile;
        $fallback = false;

        // fallback cases will receive TTS

        if (is_null($phoneNumber) || trim($phoneNumber) == '') {
            $phoneNumber = $this->phonenumber;
            $fallback = true;
        }

        if ($obfuscate) {
            $phoneNumber = substr($phoneNumber, 0, 3) . preg_replace("/./",
                    "*",
                    substr($phoneNumber, 4, strlen($phoneNumber) - 6)) . substr($phoneNumber, -3, 3);
        }
        return [
            'phoneNumber' => $phoneNumber,
            'fallback'    => $fallback
        ];

    }

    /**
     * Get the two-factor auth record associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function twoFactorAuth(): HasOne
    {
        return $this->hasOne(\MichaelDzjap\TwoFactorAuth\Models\TwoFactorAuth::class,
            'user_id',
            $this->getKeyName());
    }

    /**
     * Set the two-factor auth id.
     *
     * @param string $id
     * @return void
     */
    public function setTwoFactorAuthId(string $id): void
    {
        $enabled = config('twofactor-auth.enabled', 'user');

        if ($enabled === 'user') {
            $this->twoFactorAuth->update(['id' => $id]);
        }

        if ($enabled === 'always') {
            $this->upsertTwoFactorAuthId($id);
        }
    }

    /**
     * Get the two-factor auth id.
     *
     * @return string
     */
    public function getTwoFactorAuthId(): string
    {
        return $this->twoFactorAuth->id;
    }

    /**
     * Create or update a two-factor authentication record with the given id.
     *
     * @param string $id
     * @return void
     */
    private function upsertTwoFactorAuthId(string $id): void
    {
        DB::transaction(function () use ($id) {
            $attributes = ['id' => $id];

            if ( ! $this->twoFactorAuth()->exists()) {
                $this->twoFactorAuth()->create($attributes);
            } else {
                $this->twoFactorAuth->update($attributes);
            }
        });
    }
}
