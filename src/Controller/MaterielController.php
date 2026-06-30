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
        $data = json_decode($request->getContent(), true);
        if (!$data) return $this->json(['error' => 'Invalid JSON'], 400);
        $materiel = new Materiel();
        $materiel->setNom($data['nom'] ?? null);
        $materiel->setCategorie($data['categorie'] ?? null);
        $materiel->setReference($data['reference'] ?? null);
        if (!empty($data['dateAchat'])) 
            $materiel->setDateAchat(new \DateTime($data['dateAchat']));
        $materiel->setDisponible($data['disponible'] ?? true);
        $this->em->persist($materiel);
        $this->em->flush();

        return $this->json(['message' => 'le matériel a bien été créé avec un succès fulgurant'], 201);

    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        // ici je récupere le matérielcen utilisant l id de l'urlet je le met dans $materiel
        $materiel = $this->materielRepository->find($id);
        // si le matériel n'existe pas je retourne une erreur 404
        if (!$materiel) return $this->json(['error' => 'Materiel not found'], 404);
        // là je récupere les données  de la requete et je les met dans $data
        $data = json_decode($request->getContent(), true);
        // si les données sont invalides je retourne une erreur 400
        if (!$data) return $this->json(['error' => 'Invalid JSON'], 400);
        // là je met à jour les données du (nom,categorie et reference et dateAchat et de disponible ) avec les données de la requete
        if (array_key_exists('nom', $data)) {$materiel->setNom($data['nom']);}
        if (array_key_exists('categorie', $data)) {$materiel->setCategorie($data['categorie']);}
        if (array_key_exists('reference', $data)) {$materiel->setReference($data['reference']);}
        if (array_key_exists('dateAchat', $data)) {$materiel->setDateAchat($data['dateAchat'] ? new \DateTime($data['dateAchat']) : null );}
        if (array_key_exists('disponible', $data)) {$materiel->setDisponible($data['disponible']);}
        $this->em->flush();
        return $this->json(['message' => 'le matériel a bien été mi à jour']);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $ùmateriel = $this->materielRepository->find($id);
        if (!$materiel) return $this->json(['error' => 'Materielnontrouvé'], 404);
        $this->em->remove($materiel);
        $this->em->flush();
        return $this->json(['message' => 'ce matériel a bien été supprimé']);


    }
}