<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Form\LieuType;
use App\Repository\LieuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/lieu')]
class LieuController extends AbstractController
{
    /**
     * Afficher TOUTES les entités Lieu
     * @param LieuRepository $lieuRepository
     * @return Response
     */
    #[Route('/', name: 'lieu_index', methods: ['GET'])]
    public function index(LieuRepository $lieuRepository): Response
    {
        return $this->render('pages/lieu/index.html.twig', [
            'lieus' => $lieuRepository->findAll(),
        ]);
    }


    /**
     * Ajouter une nouvelle entité Lieu
     * @param Request $request
     * @param LieuRepository $lieuRepository
     * @return Response
     */
    #[Route('/new', name: 'lieu_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LieuRepository $lieuRepository): Response
    {
        $lieu = new Lieu();
        $form = $this->createForm(LieuType::class, $lieu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lieuRepository->add($lieu, true);

            return $this->redirectToRoute('lieu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/lieu/new.html.twig', [
            'lieu' => $lieu,
            'form' => $form,
        ]);
    }

    /**
     * Afficher une entité par ID
     * @param Lieu $lieu
     * @return Response
     */
    #[Route('/{id}', name: 'lieu_show', methods: ['GET'])]
    public function show(Lieu $lieu): Response
    {

        return $this->render('pages/lieu/show.html.twig', [
            'lieu' => $lieu,
        ]);
    }

    /**
     * Modifier une entité Lieu
     * @param Request $request
     * @param Lieu $lieu
     * @param LieuRepository $lieuRepository
     * @return Response
     */
    #[Route('/{id}/edit', name: 'lieu_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Lieu $lieu, LieuRepository $lieuRepository): Response
    {
        $form = $this->createForm(LieuType::class, $lieu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lieuRepository->add($lieu, true);

            return $this->redirectToRoute('lieu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/lieu/edit.html.twig', [
            'lieu' => $lieu,
            'form' => $form,
        ]);
    }

    /**
     * Supprimer une entité Lieu
     * @param Request $request
     * @param Lieu $lieu
     * @param LieuRepository $lieuRepository
     * @return Response
     */
    #[Route('/{id}', name: 'lieu_delete', methods: ['POST'])]
    public function delete(Request $request, Lieu $lieu, LieuRepository $lieuRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lieu->getId(), $request->request->get('_token'))) {
            $lieuRepository->remove($lieu, true);
        }

        return $this->redirectToRoute('lieu_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * Récupérer la data au format JSON pour la renvoyer vers le DOM via le fichier map.js
     * @param Lieu $lieu
     * @param LieuRepository $lieuRepository
     * @return Response (format JSON)
     */
    #[Route('/api/{id}', name: 'lieu_api')]
    public function getApi(Lieu $lieu, LieuRepository $lieuRepository,$id): Response
    {
            $lieuId = [
                'id' => $lieu->getId(),
                'nom' => $lieu->getNom(),
                'latitude' => $lieu->getLatitude(),
                'longitude'=>$lieu->getLongitude()
            ];


        return new JsonResponse($lieuId);
    }
}
