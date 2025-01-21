<?php

namespace App\Controller;

use App\Entity\Investissement;
use App\Form\InvestissementType;
use App\Entity\Projet;
use App\Repository\InvestissementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/investissement/front')]
class InvestissementFrontController extends AbstractController
{
    #[Route('/f', name: 'app_projet', methods: ['GET'])]
    public function indexFRONT(ProjetRepository $projetRepository): Response
    {
        return $this->render('projet/indexFRONT.html.twig', [
            'projets' => $projetRepository->findAll(),
        ]);
    }
   
    #[Route('/new/front/{projetId}', name: 'app_investissement_front_new', methods: ['GET', 'POST'])]
    public function new(Request $request, $projetId, EntityManagerInterface $entityManager): Response
    {
        // Fetch the projet based on the projet ID
        $projet = $this->getDoctrine()->getRepository(Projet::class)->find($projetId);
        
        // Create a new instance of Investissement and associate the projet with it
        $investissement = new Investissement();
        $investissement->setProjet($projet); // Corrected variable name to $projet
    
        // Create the form
        $form = $this->createForm(InvestissementType::class, $investissement);
        $form->handleRequest($request);
    
        // Handle form submission
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($investissement);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_investissement_front_index', [], Response::HTTP_SEE_OTHER);
        }
    
        // Render the form
        return $this->renderForm('investissement_front/new.html.twig', [
            'investissement' => $investissement,
            'form' => $form,
            'projet' => $projet, // Pass the projet variable to the template
        ]);
    }
    

    #[Route('/{idInvestissement}/front', name: 'app_investissement_front_show', methods: ['GET'])]
    public function show(Investissement $investissement): Response
    {
        return $this->render('investissement_front/show.html.twig', [
            'investissement' => $investissement,
        ]);
    }

    #[Route('/{idInvestissement}/edit/front', name: 'app_investissement_front_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Investissement $investissement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InvestissementType::class, $investissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_investissement_front_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('investissement_front/edit.html.twig', [
            'investissement' => $investissement,
            'form' => $form,
        ]);
    }

    #[Route('/{idInvestissement}/front', name: 'app_investissement_front_delete', methods: ['POST'])]
    public function delete(Request $request, Investissement $investissement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$investissement->getIdInvestissement(), $request->request->get('_token'))) {
            $entityManager->remove($investissement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_investissement_front_index', [], Response::HTTP_SEE_OTHER);
    }
}
