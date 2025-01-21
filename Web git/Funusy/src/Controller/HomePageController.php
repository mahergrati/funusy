<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use App\Entity\Compte;
use App\Form\CompteType;
use App\Repository\CompteRepository;
use Doctrine\ORM\EntityManagerInterface;

class HomePageController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/', name: 'app_home_page')]
    public function index(): Response
    {
        return $this->render('FRONT/index.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }
    #[Route('/home/page/signedIn', name: 'app_home_page2')]
    public function index2(): Response
    {
        return $this->render('FRONT/index2.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }


    #[Route('/testback', name: 'app_testback')]
    public function indexBACK(ProjetRepository $projetRepository): Response
    {
        $client = HttpClient::create();

        //$response = $client->request('GET', 'https://api.polygon.io/v2/aggs/grouped/locale/us/market/stocks/2023-01-09?adjusted=true&apiKey=O43DBF8Qpt8sD1DU9vfiJDThNmX1JMbf');



        //$data = $response->toArray();


        //if ($response->getStatusCode() === 200) {
            $stocks = [
                [
                    'name' => 'AAPL',
                    'changePercentage' => rand(-100, 100),
                ],
                [
                    'name' => 'AMZN',
                    'changePercentage' => rand(-100, 100),
                ],
                [
                    'name' => 'GOOGL',
                    'changePercentage' => rand(-100, 100),
                ],
                [
                    'name' => 'MSFT',
                    'changePercentage' => rand(-100, 100),
                ],
                [
                    'name' => 'FB',
                    'changePercentage' => rand(-100, 100),
                ],
                [
                    'name' => 'TSLA',
                    'changePercentage' => rand(-100, 100),
                ],
                [
                    'name' => 'BRK-B',
                    'changePercentage' => rand(-100, 100),
                ],
                [
                    'name' => 'JPM',
                    'changePercentage' => rand(-100, 100),
                ],
                [
                    'name' => 'JNJ',
                    'changePercentage' => rand(-100, 100),
                ],
                [
                    'name' => 'V',
                    'changePercentage' => rand(-100, 100),
                ],
                [
                    'name' => 'PG',
                    'changePercentage' => rand(-100, 100),
                ],
                [
                    'name' => 'MA',
                    'changePercentage' => rand(-100, 100),
                ],
                [
                    'name' => 'UNH',
                    'changePercentage' => rand(-100, 100),
                ],
                [
                    'name' => 'HD',
                    'changePercentage' => rand(-100, 100),
                ],
                [
                    'name' => 'NVDA',
                    'changePercentage' => rand(-100, 100),
                ],
                [
                    'name' => 'BAC',
                    'changePercentage' => rand(-100, 100),
                ],
                [
                    'name' => 'KO',
                    'changePercentage' => rand(-100, 100),
                ],
                [
                    'name' => 'DIS',
                    'changePercentage' => rand(-100, 100),
                ],
                [
                    'name' => 'CMCSA',
                    'changePercentage' => rand(-100, 100),
                ],

            ];

      //  } else {
           $stocks = [
               [

                   'name' => 'AAPL',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'MSFT',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'AMZN',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'GOOGL',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'TSLA',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'BRK-B',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'JPM',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'JNJ',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'V',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'PG',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'MA',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'UNH',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'HD',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'NVDA',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'BAC',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'KO',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'DIS',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'CMCSA',

                   'changePercentage' => rand(-10, 10),

               ],[

                   'name' => 'AAPL',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'MSFT',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'AMZN',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'GOOGL',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'TSLA',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'BRK-B',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'JPM',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'JNJ',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'V',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'PG',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'MA',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'UNH',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'HD',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'NVDA',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'BAC',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'KO',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'DIS',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'CMCSA',

                   'changePercentage' => rand(-10, 10),

               ],[

                   'name' => 'AAPL',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'MSFT',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'AMZN',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'GOOGL',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'TSLA',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'BRK-B',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'JPM',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'JNJ',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'V',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'PG',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'MA',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'UNH',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'HD',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'NVDA',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'BAC',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'KO',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'DIS',

                   'changePercentage' => rand(-10, 10),

               ],

               [

                   'name' => 'CMCSA',

                   'changePercentage' => rand(-10, 10),

               ],

            ];
          //  throw new \Exception('Failed to get data from the API.');

       // }
       $projets = $projetRepository->findAll();
       $projectCountByType = $projetRepository->getProjectCountByType();
       $investedProjectCount = $projetRepository->getInvestedProjectCount();
       $comptesEpargne = $this->entityManager->getRepository(Compte::class)->findBy(['typeCompte' => 'epargne']);
       $comptesCourant = $this->entityManager->getRepository(Compte::class)->findBy(['typeCompte' => 'courant']);
       $comptesBloque = $this->entityManager->getRepository(Compte::class)->findBy(['typeCompte' => 'bloque']);

       $stats = [
           'epargne' => count($comptesEpargne),
           'courant' => count($comptesCourant),
           'bloque' => count($comptesBloque),
       ];

        return $this->render('BACK/index.html.twig', [
            'projets' => $projets,
            'projectCountByType' => $projectCountByType,
            'investedProjectCount' => $investedProjectCount,
            'stats' => $stats,
            'stocks' => $stocks,
        ]);

    
    }
}
