<?php


namespace App\Models;


use OTPHP\TOTP;

class Token
{
    private string $token;

    public function __construct()
    {
        $otp = TOTP::create();
        $this->token = $otp->getSecret();

    }

    public function getToken(): string
    {
        return $this->token;
    }
}