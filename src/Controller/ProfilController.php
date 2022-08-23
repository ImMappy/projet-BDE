<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ModifProfilFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')] /* get $id from l'URL, and don't forget {id} in ROUTE */
    public function afficheProfil(): Response
    {
        return $this->render('profil/profil.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }

    #[Route('/profil/modif', name: 'app_modif_profil')] /* get $id from l'URL, and don't forget {id} in ROUTE */
    public function modifProfil(Request $request, EntityManagerInterface $em): Response
    {
        $user = new User();
        $profilForm = $this->createForm(ModifProfilFormType::class, $user);
        $profilForm->handleRequest($request);

        if ($profilForm->isSubmitted() && $profilForm->isValid()){
            $userInfo = $profilForm->getData();
            $em->persist($userInfo);
            $em->flush();

            $this->addFlash("message-success", ("Le profil a été modifié avec succès"));

            return $this->redirectToRoute("app_profil");
        }

        return $this->render('profil/modifProfil.html.twig', [
           "profilForm" => $profilForm->createView()
        ]);
    }

}
