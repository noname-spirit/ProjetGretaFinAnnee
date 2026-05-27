<?php

namespace App\Controller;

use App\Entity\ArticleBlog;
use App\Repository\ActiviteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FrontController extends AbstractController
{
    #[Route('/', name: 'front_index')]
    public function index(EntityManagerInterface $entityManager, ActiviteRepository $activiteRepo): Response
    {
        $articles = $entityManager->getRepository(ArticleBlog::class)->findBy([], ['createdAt' => 'DESC'], 6);
        $activites = $activiteRepo->findAll();

        return $this->render('front/index.html.twig', [
            'articles' => $articles,
            'activites' => $activites,
        ]);
    }
}
