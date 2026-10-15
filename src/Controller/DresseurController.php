<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Dresseur;
use App\Form\DresseurType;
use App\Repository\DresseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class DresseurController extends AbstractController
{
    #[Route('/dresseurs', name: 'app_dresseur_index', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function index(
        #[CurrentUser] User $user,
        DresseurRepository $dresseurRepository,
    ): Response {
        return $this->render('dresseur/index.html.twig', [
            'dresseurs' => $dresseurRepository->findAllForUser($user),
        ]);
    }

    #[Route('/dresseurs/nouveau', name: 'app_dresseur_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(
        #[CurrentUser] User $user,
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        $dresseur = (new Dresseur())->setUser($user);
        $form = $this->createForm(DresseurType::class, $dresseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($dresseur);
            $entityManager->flush();

            $this->addFlash('success', 'Le dresseur a été créé.');

            return $this->redirectToRoute('app_dresseur_index');
        }

        return $this->render('dresseur/new.html.twig', [
            'form' => $form,
        ]);
    }
}
