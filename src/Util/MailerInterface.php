<?php


namespace App\Util;


Interface MailerInterface
{
    public function sendRegistration(array $to);
}