<?php


namespace App\Util;


use Psr\Log\LoggerInterface;
use Swift_Mailer;
use Swift_Message;
use Swift_RfcComplianceException;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class Mailer implements MailerInterface
{
    private $mailer;
    private $templating;
    private $logger;
    private $noreply;

    public function __construct(Swift_Mailer $mailer, EngineInterface $templating, LoggerInterface $logger, array $noreply){
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->logger = $logger;
        $this->noreply = $noreply;
    }

    public function sendRegistration(array $to)
    {
        $body = $this->templating->render(
            'email/registration.html.twig', [
                'name' => 'Gino Luiggi',
                'message' => 'Gracias por todo',
            ]
        );

        $this->send($to, 'Registration confirmation!', $body, 'registration');
    }


    private function send($to, $subject, $body, $messageId)
    {
        $failedRecipients = [];

        $message = (new Swift_Message('Asunto de prueba'))
            ->setSubject($subject)
            ->setFrom($this->noreply)
            ->setTo($to)
            ->setBody($body, 'text/html');
        $message->getHeaders()->addTextHeader('X-Message-ID', $messageId);

        try {
            $this->mailer->send($message, $failedRecipients);
        } catch (Swift_RfcComplianceException $e) {
            $this->logger->critical(
                sprintf(
                    'Failed to send email to recipients [%s] with message: %s',
                    implode(', ', $failedRecipients),
                    $e->getMessage()
                )
            );
        }
    }

}