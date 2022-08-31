<?php

namespace App\Controller;

use App\Entity\Ville;
use App\Form\VilleType;
use App\Repository\VilleRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ADMIN")
 */
#[Route('/ville')]
class VilleController extends AbstractController
{
    /**
     * Afficher TOUTES les entités Ville
     * @param VilleRepository $villeRepository
     * @return Response
     */
    #[Route('/', name: 'ville_index', methods: ['GET'])]
    public function index(VilleRepository $villeRepository): Response
    {
        return $this->render('pages/ville/index.html.twig', [
            'villes' => $villeRepository->findAll(),
        ]);
    }

    /**
     * Ajouter une nouvelle entité Ville
     * @param Request $request
     * @param VilleRepository $villeRepository
     * @return Response
     */
    #[Route('/new', name: 'ville_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VilleRepository $villeRepository): Response
    {
        $ville = new Ville();
        $form = $this->createForm(VilleType::class, $ville);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $villeRepository->add($ville, true);

            return $this->redirectToRoute('ville_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/ville/new.html.twig', [
            'ville' => $ville,
            'form' => $form,
        ]);
    }

    /**
     * Afficher une entité Ville par ID
     * @param Ville $ville
     * @return Response
     */
    #[Route('/{id}', name: 'ville_show', methods: ['GET'])]
    public function show(Ville $ville): Response
    {
        return $this->render('pages/ville/show.html.twig', [
            'ville' => $ville,
        ]);
    }

    /**
     * Modifier une entité Ville
     * @param Request $request
     * @param Ville $ville
     * @param VilleRepository $villeRepository
     * @return Response
     */
    #[Route('/{id}/edit', name: 'ville_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ville $ville, VilleRepository $villeRepository): Response
    {
        $form = $this->createForm(VilleType::class, $ville);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $villeRepository->add($ville, true);

            return $this->redirectToRoute('ville_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/ville/edit.html.twig', [
            'ville' => $ville,
            'form' => $form,
        ]);
    }

    /**
     * Supprimer une entité Ville
     * @param Request $request
     * @param Ville $ville
     * @param VilleRepository $villeRepository
     * @return Response
     */
    #[Route('/{id}', name: 'ville_delete', methods: ['POST'])]
    public function delete(Request $request, Ville $ville, VilleRepository $villeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ville->getId(), $request->request->get('_token'))) {
            $villeRepository->remove($ville, true);
        }

        return $this->redirectToRoute('ville_index', [], Response::HTTP_SEE_OTHER);
    }
}
