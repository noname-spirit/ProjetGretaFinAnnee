<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;

class EmailVerifier
{
    public function __construct(
        private MailerInterface $mailer,
        private EntityManagerInterface $entityManager
    ) {}

    public function sendEmailConfirmation(string $verifyEmailRouteName, User $user, TemplatedEmail $email): void
    {
        $this->mailer->send($email);
    }

    public function handleEmailConfirmation(Request $request, User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
