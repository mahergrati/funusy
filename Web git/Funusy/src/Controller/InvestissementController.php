<?php

namespace App\Controller;

use App\Entity\Investissement;
use App\Form\InvestissementType;
use App\Repository\InvestissementRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Projet;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Form\FormError;
#[Route('/investissement')]
class InvestissementController extends AbstractController
{
    #[Route('/', name: 'app_investissement_front_index', methods: ['GET'])]
    public function indexfont(InvestissementRepository $investissementRepository, ProjetRepository $projetRepository): Response
    {
        $investissements = $investissementRepository->findAll();
        $projets = $projetRepository->findAll(); // Fetch all projects
    
        return $this->render('investissement_front/index.html.twig', [
            'investissements' => $investissements,
            'projets' => $projets, // Pass the list of projects to the template
        ]);
    }
    
    #[Route('/back', name: 'app_investissement_index', methods: ['GET'])]
    public function indexBACK(InvestissementRepository $investissementRepository): Response
    {
        return $this->render('investissement/indexBACK.html.twig', [
            'investissements' => $investissementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_investissement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, investissementRepository $investissementRepository, ValidatorInterface $validator): Response
    {
        $investissement = new Investissement();
        $form = $this->createForm(InvestissementType::class, $investissement);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Check if an investment with the same attributes already exists
            $existingInvestissement = $investissementRepository->findOneBy([
                'montant' => $investissement->getMontant(),
                'dateInv' => $investissement->getDateInv(),
                'periode' => $investissement->getPeriode(),
                'user' => $investissement->getUser(),
                'projet' => $investissement->getProjet(),
            ]);
            
            if ($existingInvestissement) {
                $form->addError(new FormError('An investment with these attributes already exists.'));
            } else {
                $entityManager->persist($investissement);
                $entityManager->flush();
                return $this->redirectToRoute('app_investissement_index');
            }
        }
    
        return $this->render('investissement/new.html.twig', [
            'investissement' => $investissement,
            'form' => $form->createView(),
        ]);
    }
    

    #[Route('/{idInvestissement}', name: 'app_investissement_show', methods: ['GET'])]
    public function show(Investissement $investissement): Response
    {
        return $this->render('investissement/show.html.twig', [
            'investissement' => $investissement,
        ]);
    }

    #[Route('/{idInvestissement}/edit', name: 'app_investissement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Investissement $investissement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InvestissementType::class, $investissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_investissement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('investissement/edit.html.twig', [
            'investissement' => $investissement,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{idInvestissement}', name: 'app_investissement_delete', methods: ['POST'])]
    public function delete(Request $request, Investissement $investissement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $investissement->getIdInvestissement(), $request->request->get('_token'))) {
            $entityManager->remove($investissement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_investissement_index', [], Response::HTTP_SEE_OTHER);
    }
}
