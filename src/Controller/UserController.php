<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use Doctrine\Persistence\ManagerRegistry;

class UserController extends AbstractController
{
    #[Route('/users', name: 'user_list')]
    public function listAction(ManagerRegistry $doctrine)
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->render('default/index.html.twig');
        }

        return $this->render('user/list.html.twig', ['users' => $doctrine->getRepository(User::class)->findAll()]);
    }

    #[Route('/users/create', name: 'user_create')]
    public function createAction(Request $request,UserPasswordHasherInterface   $encoder,ManagerRegistry $doctrine)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $password = $encoder->hashPassword($user, $user->getPassword());
            $user->setPassword($password);

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('homepage');
        }

        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/users/{id}/edit', name: 'user_edit')]
    public function editAction(User $user, Request $request,ManagerRegistry $doctrine,UserPasswordHasherInterface   $encoder)
    {

        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->render('default/index.html.twig');
        }
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password =  $encoder->hashPassword($user, $user->getPassword());
            $user->setPassword($password);

            $doctrine->getManager()->flush();

            $this->addFlash('success', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
}
