<?php

namespace App\Controller\Admin;

use App\Entity\ArticleBlog;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud; // <<< THIS WAS THE MISSING PIECE from the last full example
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field; // For generic fields / custom templates / FileType
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Component\Form\Extension\Core\Type\FileType; // For the upload form type
use Symfony\Component\HttpFoundation\File\UploadedFile; // For typehint in processImageUpload

class ArticleBlogCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ArticleBlog::class;
    }

    public function configureFields(string $pageName): iterable
    {

        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('title', 'Titre'),
            TextField::new('subTitle', 'Sous-titre')->setRequired(false),
            TextEditorField::new('content', 'Contenu'),
            ImageField::new('image')
            ->setBasePath('/uploads/articles')
            ->setUploadDir('public/uploads/articles')
            ->setRequired(false),
            DateTimeField::new('createdAt', 'Date de création')
                ->setFormat('dd/MM/yyyy HH:mm')
                ->hideOnForm()
        ];

    }
}
