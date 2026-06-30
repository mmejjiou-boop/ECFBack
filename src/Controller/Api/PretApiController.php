<?php
namespace App\Controller\Api;

use App\Entity\Pret;
use App\Repository\PretRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/pret', name: 'api_prets_')]
#[IsGranted('ROLE_ADMIN')]
final class PretApiController extends AbstractController
{
    #[Route(name: 'list', methods: ['GET'])]
    public function list(PretRepository $pretRepository): JsonResponse
    {
        $prets = $pretRepository->findAll();

        $data = array_map(fn(Pret $pret) => [
            'id' => $pret->getId(),
            'datePret' => $pret->getDatePret()?->format('Y-m-d'),
            'dateRetourPrevue' => $pret->getDateRetourPrevue()?->format('Y-m-d'),
            'dateRetourEffective' => $pret->getDateRetourEffective()?->format('Y-m-d'),
            'materielId' => $pret->getMateriel()?->getId(),
            'adherentId' => $pret->getAdherent()?->getId(),
        ], $prets);

        return $this->json($data);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(int $id, PretRepository $pretRepository): JsonResponse
    {
        $pret = $pretRepository->find($id);

        if (!$pret) {
            return $this->json(['error' => 'Pret not found'], 404);
        }

        return $this->json([
            'id' => $pret->getId(),
            'datePret' => $pret->getDatePret()?->format('Y-m-d'),
            'dateRetourPrevue' => $pret->getDateRetourPrevue()?->format('Y-m-d'),
            'dateRetourEffective' => $pret->getDateRetourEffective()?->format('Y-m-d'),
            'materielId' => $pret->getMateriel()?->getId(),
            'adherentId' => $pret->getAdherent()?->getId(),
        ]);
    }
}