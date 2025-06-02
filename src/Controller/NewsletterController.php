<?php

namespace App\Controller;

use App\Entity\NewLetterAbonne;
use App\Repository\ActiviteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NewsletterController extends AbstractController
{
    #[Route('/newsletter/register', name: 'newsletter_register', methods: ['POST'])]
    public function register(Request $request, EntityManagerInterface $em, ActiviteRepository $activiteRepo): Response
    {
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $email = $request->request->get('email');
        $activiteId = $request->request->get('activite');

        if (!$nom || !$prenom || !$email || !$activiteId) {
            $this->addFlash('error', 'Tous les champs sont obligatoires.');
            return $this->redirectToRoute('front_index');
        }

        $activite = $activiteRepo->find($activiteId);
        if (!$activite) {
            $this->addFlash('error', 'Activité invalide.');
            return $this->redirectToRoute('front_index');
        }

        $abonne = new NewLetterAbonne();
        $abonne->setNom($nom)
            ->setPrenom($prenom)
            ->setEmail($email)
            ->setActivite($activite);

        $em->persist($abonne);
        $em->flush();

        $this->addFlash('success', 'Merci pour votre inscription à la newsletter !');

        return $this->redirectToRoute('front_index');
    }
}
