<?php

namespace App\Controller\Admin;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\User;
use App\Entity\Ville;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator->setController(SortieCrudController::class)->generateUrl();
        return $this->redirect($url);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Projet BDE');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::subMenu('Sorties', 'fa-solid fa-person-walking-arrow-right')->setSubItems([
            MenuItem::linkToCrud('Ajouter une sortie','fas fa-plus',Sortie::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Modifier une sortie','fa-solid fa-pen',Sortie::class)->setAction(Crud::PAGE_EDIT),
            MenuItem::linkToCrud('Toutes les sorties','fa-solid fa-eye',Sortie::class)
        ]);
        yield MenuItem::subMenu('Campus', 'fa-solid fa-school')->setSubItems([
            MenuItem::linkToCrud('Ajouter un campus','fas fa-plus',Campus::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Modifier un campus','fa-solid fa-pen',Campus::class)->setAction(Crud::PAGE_EDIT),
            MenuItem::linkToCrud('Tous les campus','fa-solid fa-eye',Campus::class)
        ]);
        yield MenuItem::subMenu('Étudiants','fa-solid fa-graduation-cap')->setSubItems([
            MenuItem::linkToCrud('Ajouter un étudiant','fas fa-plus',User::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Modifier un profil','fas fa-pen',User::class)->setAction(Crud::PAGE_EDIT),
            MenuItem::linkToCrud('Tous les étudiants','fas fa-eye',User::class)
        ]);
        yield MenuItem::subMenu('État','fa-solid fa-spinner')->setSubItems([
            MenuItem::linkToCrud('Ajouter un état','fas fa-plus',Etat::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Modifier un état','fas fa-pen',Etat::class)->setAction(Crud::PAGE_EDIT),
            MenuItem::linkToCrud('Tous les états','fas fa-eye',User::class)
        ]);
        yield MenuItem::subMenu('Lieux','fa-solid fa-location-pin')->setSubItems([
            MenuItem::linkToCrud('Ajouter un lieu','fas fa-plus',Lieu::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Modifier un lieu','fas fa-pen',Lieu::class)->setAction(Crud::PAGE_EDIT),
            MenuItem::linkToCrud('Tous les lieux','fas fa-eye',Lieu::class)
        ]);
        yield MenuItem::subMenu('Villes','fa-solid fa-city')->setSubItems([
            MenuItem::linkToCrud('Ajouter une ville','fas fa-plus',Ville::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Modifier une ville','fas fa-pen',Ville::class)->setAction(Crud::PAGE_EDIT),
            MenuItem::linkToCrud('Toutes les villes','fas fa-eye',Ville::class)
        ]);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
