<?php

namespace App\Form;

use App\Entity\ArticleBlog;
use App\Entity\Commentaire;
use phpDocumentor\Reflection\PseudoTypes\False_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentaireFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('article', EntityType::class, [
                'class' => ArticleBlog::class,
                'row_attr' => [
                    'class' => 'd-none'
                ]
            ])
            ->add('message')
            ->add('send', SubmitType::class, [
                'label' => 'Envoyer',
                'row_attr' => [
                    'class' => 'text-center'
                ]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
            'allow_extra_fields ' => true,
        ]);
    }
}
