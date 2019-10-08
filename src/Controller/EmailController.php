<?php

namespace App\Controller;

use App\Services\MailerServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EmailController extends AbstractController
{

    /**
     *
     *
     * @Route("/email/{name}", name="email")
     * @param string $name
     * @param MailerServiceInterface $mailerService
     */
    public function index($name, MailerServiceInterface $mailerService)
    {

        $mailerService->sendEmail();

        var_dump('send email');
        exit();
    }
}
