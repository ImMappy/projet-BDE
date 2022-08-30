<?php

namespace App\Controller;


use App\Entity\Etat;
use App\Entity\Sortie;
use App\Entity\User;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sortie')]
class SortieController extends AbstractController
{
    /**
     * @param SortieRepository $sortieRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/', name: 'sortie_index', methods: ['GET'])]
    public function index(SortieRepository $sortieRepository,PaginatorInterface $paginator,Request $request): Response
    {
        $paginationSorties = $paginator->paginate(
            $sortieRepository->findAll(),
            $request->query->getInt('page',1),
            1
        );
        return $this->render('pages/sortie/index.html.twig', [
            'sorties' => $paginationSorties,


        ]);
    }

    /**
     * @param Request $request
     * @param SortieRepository $sortieRepository
     * @param UserRepository $repository
     * @param $id
     * @return Response
     */
    #[Route('/new/{id}', name: 'sortie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SortieRepository $sortieRepository, UserRepository $repository, $id): Response
    {
        $etat = new Etat();
        $sortie = new Sortie();
        $user = $repository->find($id);
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        // add organisateur to list of participants


        if ($form->isSubmitted() && $form->isValid()) {
            $sortie->setOrganisateur($user);
            $sortieRepository->add($sortie, true);
            $etat->setLibelle('Créee');
            return $this->redirectToRoute('sortie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/sortie/new.html.twig', [
            'sortie' => $sortie,
            'form' => $form,

        ]);
    }

    /**
     * @param Sortie $sortie
     * @return Response
     */
    #[Route('/{id}', name: 'sortie_show', methods: ['GET'])]
    public function show(Sortie $sortie): Response
    {
        $userCollection = $sortie->getUser();
        return $this->render('pages/sortie/show.html.twig', [
            'sortie' => $sortie,
            'userCollection' => $userCollection
        ]);
    }

    /**
     * @param Request $request
     * @param Sortie $sortie
     * @param SortieRepository $sortieRepository
     * @param UserRepository $repository
     * @param $id
     * @return Response
     */
    #[Route('/{id}/edit', name: 'sortie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sortie $sortie, SortieRepository $sortieRepository, UserRepository $repository, $id): Response
    {
        $user = $repository->find($id); // recupération de l'id user
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sortie->setOrganisateur($user);  // permet d'affecter le user (organisateur) à sa sortie
            $sortieRepository->add($sortie, true);

            return $this->redirectToRoute('sortie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/sortie/edit.html.twig', [
            'sortie' => $sortie,
            'form' => $form,
        ]);
    }

    /**
     * @param Request $request
     * @param Sortie $sortie
     * @param SortieRepository $sortieRepository
     * @return Response
     */
    #[Route('/{id}', name: 'sortie_delete', methods: ['POST'])]
    public function delete(Request $request, Sortie $sortie, SortieRepository $sortieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $sortie->getId(), $request->request->get('_token'))) {
            $sortieRepository->remove($sortie, true);
        }

        return $this->redirectToRoute('sortie_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @param Sortie $sortie
     * @param User $user
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/{id}/register', name: 'sortie_register_event', methods: ['GET','POST'])]  //appelle sortie qyi recupère l'id de la sortie
    public function registertoSortie(Sortie $sortie, User $user, EntityManagerInterface $entityManager): Response
    {
        $sortie->addUser($user); //addUser appelle la méthode située dans sortie entité et qui ajoute l'utilisateur dans une sortie // on attend de plus la variable utilisateur, qui est identitifié et récupéré automatiquement dès qu'on se log grâce au token

        $entityManager->persist($sortie); //on passe en paramètre l'entity emanager, qui gère les entités // persist prépare l'envoi de la donnée
        $entityManager->flush(); //envoi des données dans la dbb

        return $this->redirectToRoute('sortie_show', [], Response::HTTP_SEE_OTHER);
    }

    /*
    #[Route('/{id}', name: 'sortie_cancel', methods: ['POST'])]
    public function cancel(Request $request, Sortie $sortie, Etat $etat, SortieRepository $sortieRepository): Response
    {
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->isCsrfTokenValid('cancel' . $sortie->getId(), $request->request->get('_token'))) {
                $sortieRepository->remove($sortie, true);
                $etat->setLibelle('Sortie annulée');
            }
            return $this->redirectToRoute('sortie_index', [], Response::HTTP_SEE_OTHER);
        }
            return $this->renderForm('pages/sortie/cancel.html.twig', [
                'sortie' => $sortie,
                'form' => $form,
            ]);
        }

*/

}
