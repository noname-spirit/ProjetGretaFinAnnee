<?php

namespace App\Controller\Admin;

use App\Entity\NewLetterAbonne;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class NewLetterAbonneCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return NewLetterAbonne::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            TextField::new('prenom'),
            EmailField::new('email')->hideOnIndex(),
            AssociationField::new('activite')
                ->setLabel('Activité')
                ->setRequired(true),
        ];
    }
}
