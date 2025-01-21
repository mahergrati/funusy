<?php

namespace App\Controller;

use App\Entity\Echeance;
use App\Entity\Credit;
use App\Form\CreditType;
use App\Repository\CreditRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/credit/back')]
class CreditFrontController extends AbstractController
{
    #[Route('/f', name: 'app_credit_back_index', methods: ['GET'])]
    public function index(CreditRepository $creditRepository): Response
    {
        return $this->render('credit_back/index.html.twig', [
            'credits' => $creditRepository->findAll(),
        ]);
    }

    #[Route('/new/f', name: 'app_credit_back_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $credit = new Credit();
        $form = $this->createForm(CreditType::class, $credit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager= $this->getDoctrine()->getManager();
            $entityManager->persist($credit);
            $entityManager->flush();

            return $this->redirectToRoute('app_garantie_f_new', ['id_credit'=>$credit->getIdCredit()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('credit_back/new.html.twig', [
            'credit' => $credit,
            'form' => $form,
        ]);
    }

    #[Route('/{idCredit}/f', name: 'app_credit_back_show', methods: ['GET'])]
    public function show(Credit $credit): Response
    {
        return $this->render('credit_back/show.html.twig', [
            'credit' => $credit,
        ]);
    }

    #[Route('/{idCredit}/edit/f', name: 'app_credit_back_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Credit $credit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CreditType::class, $credit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_credit_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('credit_back/edit.html.twig', [
            'credit' => $credit,
            'form' => $form,
        ]);
    }

    #[Route('/{idCredit}/f  ', name: 'app_credit_back_delete', methods: ['POST'])]
    public function delete(Request $request, Credit $credit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$credit->getIdCredit(), $request->request->get('_token'))) {
            $entityManager->remove($credit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_credit_back_index', [], Response::HTTP_SEE_OTHER);
    }
}
