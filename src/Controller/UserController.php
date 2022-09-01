<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;


#[Route('/user')]
class UserController extends AbstractController
{
    /**
     * Afficher TOUTES les entités User
     * @param UserRepository $userRepository
     * @return Response
     */
    #[Route('/', name: 'user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('pages/user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * Ajouter une nouvelle entité User
     * @param Request $request
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @param UserAuthenticatorInterface $userAuthenticator
     * @param AppAuthenticator $authenticator
     * @param EntityManagerInterface $entityManager
     * @return Response
     */

    #[Route('/register', name: 'user_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user= $form->getData();
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('pages/user/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * Afficher une entité User par ID
     * @param User $user
     * @return Response
     */
    #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('pages/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * Modifier une entité User
     * @param Request $request
     * @param User $user
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserPasswordHasherInterface $userPasswordHasher, UserRepository $userRepository, EntityManagerInterface $entityManager, Sluggerinterface $slugger): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $userRepository->add($user, true);

//            $avatarFile = $form->get('image')->getData();
//
//            if ($avatarFile) {
//                $originalFilename = pathinfo($avatarFile->getClientOriginalName(), PATHINFO_FILENAME);
//                // this is needed to safely include the file name as part of the URL
//                $safeFilename = $slugger->slug($originalFilename);
//                $newFilename = $safeFilename . '-' . uniqid() . '.' . $avatarFile->guessExtension();
//
//                // Move the file to the directory where brochures are stored
//                try {
//                    $avatarFile->move(
//                        $this->getParameter('brochures_directory'),
//                        $newFilename
//                    );
//                } catch (FileException $e) {
//                    // ... handle exception if something happens during file upload
//                }
//
//                $user->setImage($newFilename);
//            }

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

            return $this->renderForm('pages/user/edit.html.twig', [
                'user' => $user,
                'form' => $form,
            ]);
        }


        /**
         * Supprimer une entité User
         * @param Request $request
         * @param User $user
         * @param UserRepository $userRepository
         * @return Response
         */
        #[
        Route('/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }

}
