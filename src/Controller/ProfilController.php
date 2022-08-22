<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }

    #[Route('/profil/modif', name: 'app_modif_profil')]
    public function modifProfil(): Response
    {
        return $this->render('profil/modifProfil.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }


}
