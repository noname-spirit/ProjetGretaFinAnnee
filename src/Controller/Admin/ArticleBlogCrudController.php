<?php

namespace App\Controller\Admin;

use App\Entity\ArticleBlog;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud; // <<< THIS WAS THE MISSING PIECE from the last full example
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
// We are not using ImageField if displaying BLOB via custom template, so it can be removed if not used elsewhere
// use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField; 
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field; // For generic fields / custom templates / FileType
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
        yield IdField::new('id')->onlyOnIndex();

        yield TextField::new('title', 'Titre');

        yield TextField::new('subTitle', 'Sous-titre')->setRequired(false);

        yield TextEditorField::new('content', 'Contenu');

        // Field for UPLOADING the image (only on forms)
        yield Field::new('imageFile', 'Image (Télécharger)')
            ->setFormType(FileType::class)
            ->setRequired($pageName === Crud::PAGE_NEW)
            ->setHelp('Téléchargez une image (JPG, PNG, GIF). Taille max: 5MB.')
            ->onlyOnForms();

        // Field for DISPLAYING the image preview (not on forms)
        yield Field::new('image', 'Image (Aperçu)')
            ->setTemplatePath('admin/field/image_blob_preview.html.twig')
            ->hideOnForm(); // <<<< CORRECTED HERE

        yield DateTimeField::new('createdAt', 'Date de création')
            ->setFormat('dd/MM/yyyy HH:mm')
            ->hideOnForm();
    }
}
