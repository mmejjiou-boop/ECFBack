<?php
namespace App\Controller;
use App\Entity\Adherent;
use App\Repository\AdherentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/adherents', name: 'api_adherents_')]
class AdherentController extends AbstractController
{
    public function __construct(
        private AdherentRepository $adherentRepository,
        private EntityManagerInterface $em
    ) {}

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $adherent = $this->adherentRepository->findAll();
        $data = array_map(fn(Adherent $adherent) => [
            'id' => $adherent->getId(),
            'nom' => $adherent->getNom(),
            'prenom' => $adherent->getPrenom(),
            'email' => $adherent->getEmail(),
            'dateAdhesion' => $adherent->getDateAdhesion(),
        ], $adherent);


      return $this->json($data);  
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!$data) return $this->json(['error' => 'Invalid JSON'], 400);
        $adherent = new Adherent();
        $adherent->setNom($data['nom'] ?? null);
        $adherent->setPrenom($data['prenom'] ?? null);
        $adherent->setEmail($data['email'] ?? null);
        if (!empty($data['dateAdhesion'])) 
            $adherent->setDateAdhesion(new \DateTime($data['dateAdhesion']));
        $this->em->persist($adherent);
        $this->em->flush();

        return $this->json(['message' => 'le adherent a bien été créé'], 201);

    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        // ici je récupere le matérielcen utilisant l id de l'urlet je le met dans $materiel
        $adherent = $this->adherentRepository->find($id);
        // si le matériel n'existe pas je retourne une erreur 404
        if (!$adherent) return $this->json(['error' => 'Adherent not found'], 404);
        // là je récupere les données  de la requete et je les met dans $data
        $data = json_decode($request->getContent(), true);
        // si les données sont invalides je retourne une erreur 400
        if (!$data) return $this->json(['error' => 'Invalid JSON'], 400);
        // là je met à jour les données du (nom et prenom et email et dateAdhesion) avec les données de la requete
        if (array_key_exists('nom', $data)) {$adherent->setNom($data['nom']);}
        if (array_key_exists('prenom', $data)) {$adherent->setPrenom($data['prenom']);}
        if (array_key_exists('email', $data)) {$adherent->setEmail($data['email']);}
        if (array_key_exists('dateAdhesion', $data)) {$adherent->setDateAdhesion($data['dateAdhesion'] ? new \DateTime($data['dateAdhesion']) : null );}
        $this->em->flush();
        return $this->json(['message' => 'le adherent a bien été mis à jour']);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $adherent = $this->adherentRepository->find($id);
        if (!$adherent) return $this->json(['error' => 'Adherent not found'], 404);
        $this->em->remove($adherent);
        $this->em->flush();
        return $this->json(['message' => 'le adherent a bien été supprimé']);


    }
}