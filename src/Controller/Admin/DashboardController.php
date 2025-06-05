<?php

namespace App\Controller\Admin;

use App\Entity\Role;
use App\Entity\User;
use App\Entity\Activite;
use App\Entity\ArticleBlog;
use App\Entity\Commentaire;
use App\Entity\NewLetterAbonne;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {

        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ProjetFinDannee');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Gestion des Entités');
        yield MenuItem::linkToCrud('Utilisaeurs', 'fas fa-list', User::class); # fas fa-list' icone a modifier #}
        yield MenuItem::linkToCrud('Activite', 'fas fa-list', Activite::class);
        yield MenuItem::linkToCrud('ArticleBlog', 'fas fa-list', ArticleBlog::class);
        yield MenuItem::linkToCrud('Commentaire', 'fas fa-list', Commentaire::class);
        yield MenuItem::linkToCrud('NewLetterAbonne', 'fas fa-list', NewLetterAbonne::class);
    }
}
