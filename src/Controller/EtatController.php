<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Form\EtatType;
use App\Repository\EtatRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
#[Route('/etat')]
class EtatController extends AbstractController
{
    /**
     * Afficher TOUTES les entités Etat
     * @param EtatRepository $etatRepository
     * @return Response
     */
    #[Route('/', name: 'etat_index', methods: ['GET'])]
    public function index(EtatRepository $etatRepository): Response
    {
        return $this->render('pages/etat/index.html.twig', [
            'etats' => $etatRepository->findAll(),
        ]);
    }

    /**
     * Ajouter une nouvelle entité Etat
     * @param Request $request
     * @param EtatRepository $etatRepository
     * @return Response
     */
    #[Route('/new', name: 'etat_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EtatRepository $etatRepository): Response
    {
        $etat = new Etat();
        $form = $this->createForm(EtatType::class, $etat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $etatRepository->add($etat, true);

            return $this->redirectToRoute('etat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/etat/new.html.twig', [
            'etat' => $etat,
            'form' => $form,
        ]);
    }

    /**
     * Afficher une entité Etat par ID
     * @param Etat $etat
     * @return Response
     */
    #[Route('/{id}', name: 'etat_show', methods: ['GET'])]
    public function show(Etat $etat): Response
    {
        return $this->render('pages/etat/show.html.twig', [
            'etat' => $etat,
        ]);
    }

    /**
     * Modifier une entité Etat
     * @param Request $request
     * @param Etat $etat
     * @param EtatRepository $etatRepository
     * @return Response
     */
    #[Route('/{id}/edit', name: 'etat_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Etat $etat, EtatRepository $etatRepository): Response
    {
        $form = $this->createForm(EtatType::class, $etat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $etatRepository->add($etat, true);

            return $this->redirectToRoute('etat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/etat/edit.html.twig', [
            'etat' => $etat,
            'form' => $form,
        ]);
    }

    /**
     * Supprimer une entité Etat
     * @param Request $request
     * @param Etat $etat
     * @param EtatRepository $etatRepository
     * @return Response
     */
    #[Route('/{id}', name: 'etat_delete', methods: ['POST'])]
    public function delete(Request $request, Etat $etat, EtatRepository $etatRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etat->getId(), $request->request->get('_token'))) {
            $etatRepository->remove($etat, true);
        }

        return $this->redirectToRoute('etat_index', [], Response::HTTP_SEE_OTHER);
    }
}
