<?php


namespace App\Services;


use App\Util\MailerInterface;

class MailerService implements MailerServiceInterface
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail(){
        $this->mailer->sendRegistration(['luiggiplasencia0823@gmail.com']);
    }
}