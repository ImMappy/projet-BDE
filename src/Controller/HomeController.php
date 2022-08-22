<?php

namespace App\Controller;

use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(SortieRepository $repository): Response
    {
        $sorties = $repository->findAll();
        return $this->render('pages/home/index.html.twig', [
            'sorties'=>$sorties
        ]);
    }

}
