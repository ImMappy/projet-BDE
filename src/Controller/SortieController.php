<?php

namespace App\Controller;


use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Sortie;
use App\Form\CancelType;
use App\Form\SortieType;
use App\Repository\CampusRepository;
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

    public function getElementByCampus()
    {

    }

    // getByName

    public function getElementByDate()
    {

    }

    public function getElementByOrganisateur()
    {

    }

    public function getElementByInscrit()
    {

    }

    public function getElementByNotInscrit()
    {

    }

    public function getElementByClosed()
    {

    }

    /**
     * Afficher toutes les Sorties
     * @param SortieRepository $sortieRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/', name: 'sortie_index', methods: ['GET'])]
    public function index(SortieRepository $sortieRepository, CampusRepository $campusRepository, PaginatorInterface $paginator,Request $request): Response
    {
        $paginationSorties = $paginator->paginate(
            $sortieRepository->findAll(),
            $request->query->getInt('page',1),
            9
        );
        return $this->render('pages/sortie/index.html.twig', [
            'sorties' => $paginationSorties,
           'campuses' => $campusRepository->findAll()
        ]);
    }

/*
    public function getElementByName(SortieRepository $sortieRepository, Request $request): Response
    {
        $sortieRepository->findBy('nom');
        return $sortieRepository;
    }
*/


    /**
     * Creer une nouvelle sortie
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
            $etat->setLibelle('Cr??ee');
            return $this->redirectToRoute('sortie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/sortie/new.html.twig', [
            'sortie' => $sortie,
            'form' => $form,

        ]);
    }

    /**
     * Montrer les details d'une Sortie
     *
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
     * Modifier une sortie
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
        $user = $repository->find($id); // recup??ration de l'id user
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sortie->setOrganisateur($user);  // permet d'affecter le user (organisateur) ?? sa sortie
            $sortieRepository->add($sortie, true);

            return $this->redirectToRoute('sortie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pages/sortie/edit.html.twig', [
            'sortie' => $sortie,
            'form' => $form,
        ]);
    }

    /**
     * Supprimer une Sortie
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


    #[Route('/{id}/register', name: 'sortie_register_event', methods: ['GET','POST'])]
    public function registertoSortie(Sortie $sortie, EntityManagerInterface $entityManager): Response
    {
        $sortie->addUser($this->getUser());
        $entityManager->persist($sortie);
        $entityManager->flush();

        return $this->redirectToRoute('sortie_show', ['id' => $sortie->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/desist', name: 'sortie_desist', methods: ['GET','POST'])]
    public function desist(Sortie $sortie, EntityManagerInterface $entityManager): Response
    {
        $sortie->removeUser($this->getUser());
        $entityManager->persist($sortie);
        $entityManager->flush();

        return $this->redirectToRoute('sortie_show', ['id' => $sortie->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/annuler/{id}',name: 'sortie_annuler',methods: ['GET','POST'])]
    public function annuler(Request $request, Sortie $sortie, SortieRepository $sortieRepository, EntityManagerInterface $entityManager, $id) : Response
    {
        $sortieRepository->find($id);
        $form = $this->createForm(CancelType::class,$sortie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($sortie);
            $entityManager->flush();

            $this->redirectToRoute('sortie_index');
        }
        return $this->renderForm('pages/sortie/cancel.html.twig',[
            'form'=>$form, // association du nom ?? la valeur
            'sortie'=>$sortie
        ]);
    }



}
