<?php

namespace App\Controller;

use App\Entity\Pret;
use App\Form\PretType;
use App\Repository\PretRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/pret')]
final class PretController extends AbstractController
{
    #[Route(name: 'app_pret_index', methods: ['GET'])]
    #[IsGranted('ROLE_GESTIONNAIRE')]  
    public function index(PretRepository $pretRepository): Response
    {
        return $this->render('pret/index.html.twig', [
            'prets' => $pretRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_pret_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_GESTIONNAIRE')]  
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $pret = new Pret();
        $form = $this->createForm(PretType::class, $pret);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pret);
            $entityManager->flush();

            return $this->redirectToRoute('app_pret_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pret/new.html.twig', [
            'pret' => $pret,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pret_show', methods: ['GET'])]
    #[IsGranted('ROLE_GESTIONNAIRE')]
    public function show(Pret $pret): Response
    {
        return $this->render('pret/show.html.twig', [
            'pret' => $pret,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pret_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_GESTIONNAIRE')]
    public function edit(Request $request, Pret $pret, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PretType::class, $pret);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_pret_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pret/edit.html.twig', [
            'pret' => $pret,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pret_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Pret $pret, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pret->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($pret);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_pret_index', [], Response::HTTP_SEE_OTHER);
    }
}
