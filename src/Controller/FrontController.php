<?php

namespace App\Controller;

use App\Entity\ArticleBlog;
use App\Repository\ActiviteRepository;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionClass;
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

    #[Route('/blog/{id}', name: 'blog_show')]
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        $article = $entityManager->getRepository(ArticleBlog::class)->find($id);

        if (!$article) {
            throw $this->createNotFoundException('L\'article demandé n\'existe pas.');
        }

        // DEBUGGING SECTION (si besoin)
        /*
        $imageValueFromGetter = $article->getImage();

        $reflection = new ReflectionClass($article);
        $imageProperty = $reflection->getProperty('image');
        $imageProperty->setAccessible(true);
        $directImagePropertyValue = $imageProperty->getValue($article);

        dump([
            'image_via_getter_type' => gettype($imageValueFromGetter),
            'direct_image_property_value_type' => gettype($directImagePropertyValue),
        ]);
        */

        return $this->render('blog/show.html.twig', [
            'article' => $article,
        ]);
    }
}
