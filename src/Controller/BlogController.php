<?php

namespace App\Controller;

use App\Entity\ArticleBlog;
use App\Entity\Commentaire;
use App\Form\CommentaireFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\NewLetterAbonneRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'blog_index')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $page = max(1, (int) $request->query->get('page', 1));
        $limit = 9;
        $offset = ($page - 1) * $limit;

        $articleRepo = $em->getRepository(ArticleBlog::class);

        // Récupération du dernier article
        $latestArticle = $articleRepo->findOneBy([], ['createdAt' => 'DESC']);
        $encodedImage = $this->encodeImage($latestArticle?->getImage());

        // Récupération des autres articles (hors dernier)
        $articles = [];
        $total = 0;

        if ($latestArticle) {
            $articles = $articleRepo->createQueryBuilder('a')
                ->where('a.id != :latestId')
                ->setParameter('latestId', $latestArticle->getId())
                ->orderBy('a.createdAt', 'DESC')
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();

            $total = $articleRepo->createQueryBuilder('a')
                ->select('COUNT(a.id)')
                ->where('a.id != :latestId')
                ->setParameter('latestId', $latestArticle->getId())
                ->getQuery()
                ->getSingleScalarResult();
        }

        $totalPages = ceil($total / $limit);

        return $this->render('front/blog.html.twig', [
            'latestArticle' => $latestArticle,
            'encodedImage' => $encodedImage,
            'articles' => $articles,
            'currentPage' => $page,
            'totalPages' => $totalPages,
        ]);
    }

    #[Route('/blog/{id}', name: 'article_show', requirements: ['id' => '\d+'])]
    public function show(ArticleBlog $article, EntityManagerInterface $entityManager): Response

    {
        $commentaire = new Commentaire();
        $commentaire->setArticle($article);
        $commentaires = $entityManager->getRepository(Commentaire::class)->findBy(['article' => $article]);

        $commentaireform = $this->createForm(CommentaireFormType::class, $commentaire, [
            'action' => $this->generateUrl('app_commentaire_new'),
            'method' => 'POST',
        ]);

        return $this->render('front/article_show.html.twig', [
            'article' => $article,
            'encodedImage' => $this->encodeImage($article->getImage()),
            'commentaireForm' => $commentaireform,
            'commentaires' => $commentaires
        ]);
    }



    private function encodeImage($stream): ?string
    {
        if (is_resource($stream)) {
            $contents = stream_get_contents($stream);
            fclose($stream);
            return base64_encode($contents);
        }

        return null;
    }
}
