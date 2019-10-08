<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Swift_Mailer;
use Swift_Message;

class ContactController extends AbstractController
{
    public function index(Request $request, Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();

            $message = (new Swift_Message($data['subject']))
                ->setFrom('luiggichirinos_p@outlook.com')
                ->setTo($data['email'])
                ->setBody(
                    $this->renderView(
                        'email/registration.html.twig'
                        , [
                            'name' => $data['name']
                            , 'message' => $data['message']
                        ]
                    )
                    , 'text/html'
                );

            $mailer->send($message);

            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
