<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Form\CompteType;
use App\Repository\CompteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController; // Import AbstractController
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

use DateTime;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/compte/back')]
class CompteBackController extends AbstractController // Extend AbstractController

{  


   
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route("/search/compte/by/rib", name:"app_search_compte_by_rib", methods: ['GET'])]
    
   public function searchCompteByRib(Request $request): Response
   {
    $query = $request->query->get('query');

        // Get the repository for the Compte entity
        $repository = $this->entityManager->getRepository(Compte::class);

        // Create a query builder
        $qb = $repository->createQueryBuilder('c');

        // Add a WHERE clause to filter by Rib starting with the given query
        $qb->andWhere($qb->expr()->like('c.rib', $qb->expr()->literal($query . '%')));

        // Execute the query
        $comptes = $qb->getQuery()->getResult();

        // Render the partial template with the filtered data
        return $this->render('compte_back/testrech.html.twig', [
            'comptes' => $comptes
        ]);


    }

   

    #[Route('/{rib}', name: 'app_compte_back_delete', methods: ['POST'])]
    public function delete(Request $request, Compte $compte, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $compte->getRib(), $request->request->get('_token'))) {
            $entityManager->remove($compte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_compte_back_index', [], Response::HTTP_SEE_OTHER);
    }



    #[Route('/error', name: 'app_compte_show_back_error', methods: ['GET', 'POST'])]
    public function indexBACK(CompteRepository $compteRepository): Response
    {
        $compte = new Compte();
        $form = $this->createForm(CompteType::class, $compte);
    
        return $this->render('compte_back/show_back.html.twig', [
            'comptes' => $compteRepository->findAll(),
            'form' => $form->createView(), 
        ]);
    }

    #[Route('/new', name: 'app_compte_back_new', methods: ['GET', 'POST'])]

    public function new(Request $request, EntityManagerInterface $entityManager,CompteRepository $CompteRepository,ValidatorInterface $validatorInterface): Response
    {
        $compte = new Compte();
        $randomRib = '';
        for ($i = 0; $i < 20; $i++) {
            $randomRib .= mt_rand(0, 9); // Append a random digit (0-9)
        }

        // Set the generated RIB as the default value for the "rib" field
        $compte->setRib($randomRib);
        $form = $this->createForm(CompteType::class, $compte);
        $form->handleRequest($request);

        $currentDateTime = new DateTime();
        
        $formattedDateTime = $currentDateTime->format('d-m-Y');
        $date = DateTime::createFromFormat('d-m-Y', $formattedDateTime);
        dump($date);

        $idUser = $compte->getIdUser();

        if ($form->isSubmitted() && $form->isValid()) {
           
            $existingCompte = $CompteRepository->findOneBy(['id_user' => $idUser]);


            if (!$existingCompte) {

            $this->addFlash('error', 'User with ID '.$idUser.' already exists !! .');
            return $this->redirectToRoute('app_compte_show_back_error');
        }

            $entityManager->persist($compte);
            $entityManager->flush();

            return $this->redirectToRoute('app_compte_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('compte_back/new.html.twig', [
            'compte' => $compte,
            'form' => $form->createView(),
        ]);
        
        
    }
    
    #[Route('/{rib}', name: 'app_compte_back', methods: ['GET'])]
    public function show(Compte $compte): Response
    {
        return $this->render('compte_back/show.html.twig', [
            'compte' => $compte,
        ]);
    }

    #[Route('/', name: 'app_compte_back_index', methods: ['GET', 'POST'])]
    public function indexFRONT(
        Request $request,
        CompteRepository $compteRepository,
        PaginatorInterface $paginator // Inject the PaginatorInterface
    ): Response {
        // Get all the comptes from the repository
        $query = $compteRepository->createQueryBuilder('c')->getQuery();
    
        // Paginate the query
        $comptes = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // Get the current page from the request
            10 // Number of items per page
        );
    
        $compte = new Compte();
        $form = $this->createForm(CompteType::class, $compte);
    
        return $this->render('compte_back/indexBACK.html.twig', [
            'comptes' => $comptes,
            'form' => $form->createView(),
        ]);
    }
    

    #[Route('/{rib}/edit', name: 'app_compte_back_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Compte $compte, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CompteType::class, $compte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_compte_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('compte_back/edit.html.twig', [
            'compte' => $compte,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/statistiques/comptes', name: 'app_comptes_statistics', methods: ['GET'])]
    public function compteStatistics(): Response
    {
        // Comptes par type (épargne, courant, bloqué)
        $comptesEpargne = $this->entityManager->getRepository(Compte::class)->findBy(['typeCompte' => 'epargne']);
        $comptesCourant = $this->entityManager->getRepository(Compte::class)->findBy(['typeCompte' => 'courant']);
        $comptesBloque = $this->entityManager->getRepository(Compte::class)->findBy(['typeCompte' => 'bloque']);

        $stats = [
            'epargne' => count($comptesEpargne),
            'courant' => count($comptesCourant),
            'bloque' => count($comptesBloque),
        ];

        // Passer les données à la vue
        return $this->render('compte_back/statistics.html.twig', [
            'stats' => $stats,
        ]);
    }
}