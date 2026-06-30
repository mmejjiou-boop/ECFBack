<?php
namespace App\Controller;
use App\Entity\Materiel;
use App\Repository\MaterielRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/materiels', name: 'api_materiels_')]
class MaterielController extends AbstractController
{
    public function __construct(
        private MaterielRepository $materielRepository,
        private EntityManagerInterface $em
    ) {}

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $materiel = $this->materielRepository->findAll();
        $data = array_map(fn(Materiel $materiel) => [
            'id' => $materiel->getId(),
            'nom' => $materiel->getnom(),
            'categorie' => $materiel->getCategorie(),
            'reference' => $materiel->getReference(),
            'dateAchat' => $materiel->getDateAchat(),
            'disponible' => $materiel->getDisponible(),

        ], $materiel);

    
      return $this->json($data);  
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {



    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {



    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {



    }
}