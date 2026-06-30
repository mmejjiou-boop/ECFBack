<?php
namespace App\Controller;
use App\Entity\Materiel;
use App\Entity\Adherent;
use App\Entity\Pret;
use App\Repository\PretRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/pret', name: 'api_pret_')]
class PretController extends AbstractController
{
    public function __construct(
        private PretRepository $pretRepository,
        private EntityManagerInterface $em
    ) {}

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $pret = $this->pretRepository->findAll();
        $data = array_map(fn(Pret $pret) => [
            'id' => $pret->getId(),
            'date_pret' => $pret->getDatePret(),
            'date_retour_prevue' => $pret->getDateRetourPrevue(),
            'date_retour_effective' => $pret->getDateRetourEffective(),
            'materiel_id' => $pret->getMateriel()->getId(),
            'adherent_id' => $pret->getAdherent()->getId(),
        ], $pret);


      return $this->json($data);  
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!$data) return $this->json(['error' => 'Invalid JSON'], 400);
        $pret = new Pret();
        $pret->setDatePret(new \DateTime());
        $pret->setDateRetourPrevue(new \DateTime($data['date_retour_prevue'] ?? null));
        $pret->setDateRetourEffective(new \DateTime($data['date_retour_effective'] ?? null));
        $this->em->persist($pret);
        $this->em->flush();

        return $this->json(['message' => 'le prêt a bien été créé'], 201);

    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(int $id, Request $request): JsonResponse
    {
        // ici je récupere le matérielcen utilisant l id de l'urlet je le met dans $materiel
        $pret = $this->pretRepository->find($id);
        // si le matériel n'existe pas je retourne une erreur 404
        if (!$pret) return $this->json(['error' => 'Pret not found'], 404);
        // là je récupere les données  de la requete et je les met dans $data
        $data = json_decode($request->getContent(), true);
        // si les données sont invalides je retourne une erreur 400
        if (!$data) return $this->json(['error' => 'Invalid JSON'], 400);
        // là je met à jour les données du (nom et prenom et email et dateAdhesion) avec les données de la requete
        if (array_key_exists('date_pret', $data)) {$pret->setDatePret($data['date_pret'] ? new \DateTime($data['date_pret']) : null );}
        if (array_key_exists('date_retour_prevue', $data)) {$pret->setDateRetourPrevue($data['date_retour_prevue'] ? new \DateTime($data['date_retour_prevue']) : null );}
        if (array_key_exists('date_retour_effective', $data)) {$pret->setDateRetourEffective($data['date_retour_effective'] ? new \DateTime($data['date_retour_effective']) : null );}
        if (array_key_exists('materiel_id', $data)) {$materiel = $this->em->getRepository(Materiel::class)->find($data['materiel_id'] ?? null); $pret->setMateriel($materiel);}
        if (array_key_exists('adherent_id', $data)) {$adherent = $this->em->getRepository(Adherent::class)->find($data['adherent_id'] ?? null); $pret->setAdherent($adherent);}
            
        
        $this->em->flush();
        return $this->json(['message' => 'le prêt a bien été mis à jour']);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $pret = $this->pretRepository->find($id);
        if (!$pret) return $this->json(['error' => 'Pret not found'], 404);
        $this->em->remove($pret);
        $this->em->flush();
        return $this->json(['message' => 'le prêt a bien été supprimé']);


    }
}