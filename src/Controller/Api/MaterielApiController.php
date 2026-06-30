<?php
namespace App\Controller\Api;

use App\Entity\Materiel;
use App\Repository\MaterielRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/materiels', name: 'api_materiels_')]
#[IsGranted('ROLE_ADMIN')]
final class MaterielApiController extends AbstractController
{
    #[Route(name: 'list', methods: ['GET'])]
    public function list(MaterielRepository $materielRepository): JsonResponse
    {
        $materiels = $materielRepository->findAll();

        $data = array_map(fn(Materiel $materiel) => [
            'id' => $materiel->getId(),
            'nom' => $materiel->getNom(),
            'categorie' => $materiel->getCategorie(),
            'reference' => $materiel->getReference(),
            'dateAchat' => $materiel->getDateAchat()?->format('Y-m-d'),
            'disponible' => $materiel->isDisponible(),
        ], $materiels);

        return $this->json($data);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id, MaterielRepository $materielRepository): JsonResponse
    {
        $materiel = $materielRepository->find($id);

        if (!$materiel) {
            return $this->json(['error' => 'Materiel not found'], 404);
        }

        return $this->json([
            'id' => $materiel->getId(),
            'nom' => $materiel->getNom(),
            'categorie' => $materiel->getCategorie(),
            'reference' => $materiel->getReference(),
            'dateAchat' => $materiel->getDateAchat()?->format('Y-m-d'),
            'disponible' => $materiel->isDisponible(),
        ]);
    }
}