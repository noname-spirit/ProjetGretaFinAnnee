<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('front/contact.html.twig');
    }

    #[Route('/contact/send', name: 'contact_send', methods: ['POST'])]
    public function send(Request $request, MailerInterface $mailer): Response
    {
        $data = $request->request;

        $email = (new Email())
            ->from('noreply@juliabpaprass.fr')
            ->replyTo($data->get('email'))
            ->to('nonamespirit@gmail.com')
            ->subject('New Contact Request from ' . $data->get('first_name') . ' ' . $data->get('last_name'))
            ->text(sprintf(
                "Name: %s %s\nEmail: %s\nPhone: %s\n\nComments:\n%s\n\nServices selected:\n%s",
                $data->get('first_name'),
                $data->get('last_name'),
                $data->get('email'),
                $data->get('phone'),
                $data->get('comments'),
                implode(", ", $data->all('services') ?? [])
            ));

        $mailer->send($email);

        $this->addFlash('success', 'Votre message a été envoyé !');
        return $this->redirectToRoute('contact');
    }
}
