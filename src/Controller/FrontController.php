<?php


namespace App\Controller;

use App\Entity\ArticleBlog;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ReflectionClass; // Import ReflectionClass

class FrontController extends AbstractController
{
    #[Route('/', name: 'front_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérer les derniers articles du blog
        $articles = $entityManager->getRepository(ArticleBlog::class)->findBy([], ['createdAt' => 'DESC'], 6);

        return $this->render('front/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/blog/{id}', name: 'blog_show')]
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'article par son identifiant
        $article = $entityManager->getRepository(ArticleBlog::class)->find($id);

        if (!$article) {
            throw $this->createNotFoundException('L\'article demandé n\'existe pas.');
        }

        // --- DEBUGGING SECTION ---
        $imageValueFromGetter = $article->getImage(); // Access via your getter

        // Access the private property directly for inspection
        $reflection = new ReflectionClass($article);
        $imageProperty = $reflection->getProperty('image');
        $imageProperty->setAccessible(true);
        $directImagePropertyValue = $imageProperty->getValue($article);

        dump([
            'article_id' => $article->getId(), // Assuming you have getId()
            'image_via_getter_type' => gettype($imageValueFromGetter),
            'image_via_getter_is_resource' => is_resource($imageValueFromGetter),
            'image_via_getter_length_if_string' => is_string($imageValueFromGetter) ? strlen($imageValueFromGetter) : 'N/A',
            'direct_image_property_value_type' => gettype($directImagePropertyValue),
            'direct_image_property_is_resource' => is_resource($directImagePropertyValue),
            'direct_image_property_length_if_string' => is_string($directImagePropertyValue) ? strlen($directImagePropertyValue) : 'N/A',
        ]);

        // If you want to try and display it (assuming it's an image and you have binary data)
        // Be careful with this, only enable if you are sure $imageValueFromGetter is binary string
        /*
        if (is_string($imageValueFromGetter) && !empty($imageValueFromGetter)) {
            // You'll need to determine the correct Content-Type (image/jpeg, image/png, etc.)
            // This is a simplification. For real display, you'd need to know the MIME type.
            return new Response($imageValueFromGetter, 200, ['Content-Type' => 'image/jpeg']);
        }
        */
        // --- END DEBUGGING SECTION ---


        // Afficher l'article dans le template Twig
        return $this->render('blog/show.html.twig', [
            'article' => $article,
        ]);
    }
}
