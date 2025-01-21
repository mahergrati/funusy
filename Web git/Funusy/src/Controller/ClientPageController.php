<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use App\Entity\CarteBancaire;
use App\Form\CarteBancaireType;
use App\Repository\CarteBancairetRepository;
use Doctrine\ORM\EntityManagerInterface;

class ClientPageController extends AbstractController
{
    #[Route('/home/client/page', name: 'app_home_client_page')]
    public function index(): Response
    {  $client = HttpClient::create();

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
      

      
        return $this->render('FRONT/indexF.html.twig', [
            'stocks' => $stocks,
           
            
        ]);
    }
   
}
