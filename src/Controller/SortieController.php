<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Sortie;
use App\Entity\User;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sortie')]
class SortieController extends AbstractController
{
    #[Route('/', name: 'sortie_index', methods: ['GET'])]
    public function index(SortieRepository $sortieRepository): Response
    {
        return $this->render('pages/sortie/index.html.twig', [
            'sorties' => $sortieRepository->findAll(),

        ]);
    }

    #[Route('/new/{id}', name: 'sortie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SortieRepository $sortieRepository,UserRepository $repository, $id): Response
    {
        $sortie = new Sortie();
        $user = $repository->find($id);
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sortie->setOrganisateur($user);
            $sortieRepository->add($sortie, true);
            return $this->redirectToRoute('sortie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/sortie/new.html.twig', [
            'sortie' => $sortie,
            'form' => $form,

        ]);
    }

    #[Route('/{id}', name: 'sortie_show', methods: ['GET'])]
    public function show(Sortie $sortie): Response
    {
        $userCollection = $sortie->getUser();
        return $this->render('pages/sortie/show.html.twig', [
            'sortie' => $sortie,
            'userCollection'=>$userCollection
        ]);
    }

    #[Route('/{id}/edit', name: 'sortie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sortie $sortie, Etat $etat, SortieRepository $sortieRepository, UserRepository $repository, $id): Response
    {
        $user = $repository->find($id); // recupération de l'id user
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sortie->setOrganisateur($user);  // permet d'affecter le user (organisateur) à sa sortie
            $sortieRepository->add($sortie, true);
            $etat->setLibelle('Créee');

            return $this->redirectToRoute('sortie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/sortie/edit.html.twig', [
            'sortie' => $sortie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'sortie_delete', methods: ['POST'])]
    public function delete(Request $request, Sortie $sortie, SortieRepository $sortieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sortie->getId(), $request->request->get('_token'))) {
            $sortieRepository->remove($sortie, true);
        }

        return $this->redirectToRoute('sortie_index', [], Response::HTTP_SEE_OTHER);
    }

    /*
    public function inscrire(User $user, Sortie $sortie, SortieRepository $sortieRepository, UserRepository $repository, $id): Response
    {
        $user = $repository->find($id);
        $sortie = $sortieRepository->find($id);

        return $this->render('pages/sortie/show.html.twig', [
            'sortie' => $sortie,
            'user' => $user,
        ]);
    }
    */

}
