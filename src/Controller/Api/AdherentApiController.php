<?php
namespace App\Controller\Api;
use App\Entity\Adherent;
use App\Repository\AdherentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/adherent')]
final class AdherentApiController extends AbstractController
{
    #[Route(name: 'api_adherent_index', methods: ['GET'])]
    public function index(AdherentRepository $adherentRepository, SerializerInterface $serializer): JsonResponse
    {
        $adherents = $adherentRepository->findAll();

        return new JsonResponse(
            $serializer->serialize($adherents, 'json', ['groups' => 'adherent:read']),
            Response::HTTP_OK,
            [],
            true
        );
    }

    #[Route('/{id}', name: 'api_adherent_show', methods: ['GET'])]
    public function show(Adherent $adherent, SerializerInterface $serializer): JsonResponse
    {
        return new JsonResponse(
            $serializer->serialize($adherent, 'json', ['groups' => 'adherent:read']),
            Response::HTTP_OK,
            [],
            true
        );
    }
}