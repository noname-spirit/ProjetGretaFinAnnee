<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MentionsLegalesController extends AbstractController
{
    #[Route('/mentions-legales', name: 'app_mentions_legales')]
    public function mentionsLegales(): Response
    {
        return $this->render('front/mentions_legales.html.twig', [
            'controller_name' => 'MentionsLegalesController',
        ]);
    }

    #[Route('/cgps', name: 'app_cgps')]
    public function cgps(): Response
    {
        return $this->render('front/cgps.html.twig', [
            'controller_name' => 'MentionsLegalesController',
        ]);
    }
}
