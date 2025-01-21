<?php

namespace App\Controller;

use App\Entity\Credit;
use App\Form\CreditType;
use App\Repository\CreditRepository;
use App\Service\TwilioService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/credit')]
class CreditController extends AbstractController
{
    #[Route('/f', name: 'app_credit', methods: ['GET'])]
    public function indexFRONT(CreditRepository $creditRepository): Response
    {
        return $this->render('credit_back/index.html.twig', [
            'credits' => $creditRepository->findAll(),
        ]);
    }

    #[Route('/', name: 'app_credit_index', methods: ['GET'])]
    public function indexBACK(CreditRepository $creditRepository): Response
    {
        return $this->render('credit/indexBACK.html.twig', [
            'credits' => $creditRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_credit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CreditRepository $creditRepository, ValidatorInterface $validator): Response
    {
        $credit = new Credit();
        $form = $this->createForm(CreditType::class, $credit);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // Check if a project with the same attributes already exists
            $existingCredit = $creditRepository->findOneBy([
                'montantCredit' => $credit->getMontantCredit(),
                'dureeCredit' => $credit->getDureeCredit(),
                'dateCredit' => $credit->getDateCredit(),
                'tauxCredit' => $credit->getTauxCredit(),
                'status' => $credit->getStatus(),
                'user' => $credit->getUser(),
            ]);

            if ($existingCredit) {
                $form->addError(new FormError('A Credit with these attributes already exists.'));
            } else {
                $entityManager->persist($credit);
                $entityManager->flush();


                return $this->redirectToRoute('app_credit_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('credit/new.html.twig', [
            'credit' => $credit,
            'form' => $form,
        ]);
    }

    #[Route('/search', name: 'app_credit_search', methods: ['GET'])]
    public function search(Request $request, CreditRepository $creditRepository): Response
    {

        $query = $request->query->get('query');

        if ($query) {
            $credits = $creditRepository->findByPartialStatus($query);
        } else {
            $credits = $creditRepository->findAll();
        }

        if ($request->isXmlHttpRequest()) {
            return $this->render('credit/search_results.html.twig', [
                'credits' => $credits,
            ]);
        } else {
            return $this->render('credit/indexBACK.html.twig', [
                'credits' => $credits,
            ]);
        }
    }


    #[Route('/{idCredit}', name: 'app_credit_show', methods: ['GET'])]
    public function show(Credit $credit): Response
    {
        return $this->render('credit/show.html.twig', [
            'credit' => $credit,
        ]);
    }

    #[Route('/{idCredit}/edit', name: 'app_credit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Credit $credit, EntityManagerInterface $entityManager, TwilioService $twilioService): Response
    {
        $form = $this->createForm(CreditType::class, $credit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $twilioService->sendCongratulationsSMS($credit);
            return $this->redirectToRoute('app_credit_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('credit/edit.html.twig', [
            'credit' => $credit,
            'form' => $form,
        ]);
    }

    #[Route('/{idCredit}', name: 'app_credit_delete', methods: ['POST'])]
    public function delete(Request $request, Credit $credit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $credit->getIdCredit(), $request->request->get('_token'))) {
            $entityManager->remove($credit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_credit_index', [], Response::HTTP_SEE_OTHER);
    }
}