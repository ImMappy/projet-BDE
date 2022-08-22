<?php

namespace App\Controller;

use App\Repository\SortieRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(SortieRepository $repository, PaginatorInterface $paginator,Request $request): Response
    {
        $paginationSorties = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
           20 /*limit per page*/
        );
        return $this->render('pages/home/index.html.twig', [
            'sorties'=>$paginationSorties
        ]);
    }

}
