<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Form\TransactionType;
use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CompteRepository;
use Knp\Snappy\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

#[Route('/transaction')]
class TransactionController extends AbstractController
{
    #[Route('/', name: 'app_transaction_index', methods: ['GET'])]
    public function indexBACK(TransactionRepository $transactionRepository): Response
    {
        return $this->render('transaction/indexBACK.html.twig', [
            'transactions' => $transactionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_transaction_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CompteRepository $compteRepository): Response
    
    {
    
        $transaction = new Transaction();
    
    
        // Fetch the Compte entity with the 'rib' field set to 'RIBTEST'
    
        $compte = $compteRepository->findOneBy(['rib' => 'RIBTEST']);
    
    
        // Set the 'rib' field of the 'transaction' object to the fetched 'compte' object
    
        $transaction->setRib($compte);
    //
    
        $form = $this->createForm(TransactionType::class, $transaction);
    
        $form->handleRequest($request);
    
    
        if ($form->isSubmitted() && $form->isValid()) {
    
            $entityManager->persist($transaction);
    
            $entityManager->flush();
    
    
            return $this->redirectToRoute('app_transaction_index', [], Response::HTTP_SEE_OTHER);
    
        }
    
    
        return $this->renderForm('transaction/new.html.twig', [
    
            'transaction' => $transaction,
    
            'form' => $form,
    
        ]);
    
    }
    #[Route('/{idTransaction}/pdf', name: 'app_transaction_pdf', methods: ['GET'])]
    public function pdf(Transaction $transaction, Pdf $pdf): Response
    {
        $html = $this->renderView('transaction/pdf.html.twig', [
            'transaction' => $transaction,
        ]);

        $pdfFile = 'path/to/save/pdf.pdf';
        if (file_exists($pdfFile)) {
            unlink($pdfFile);
        }

        // Use wkhtmltopdf instead of wkhtmltoimage
        $pdf->setBinary('wkhtmltopdf.exe');
        $pdf->generateFromHtml($html, $pdfFile);

        $response = new StreamedResponse(function () use ($pdfFile) {
            readfile($pdfFile);
        });

        // Set the Content-Type and Content-Disposition headers
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename="' . basename($pdfFile) . '"');

        return $response;
    }
   #[Route('/{idTransaction}', name: 'app_transaction_show', methods: ['GET'])]
    public function show(Transaction $transaction): Response
    {
        return $this->render('transaction/show.html.twig', [
            'transaction' => $transaction,
        ]);
    }
/*
    #[Route('/{idTransaction}/edit', name: 'app_transaction_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Transaction $transaction, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_transaction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transaction/edit.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
        ]);
    }
*/
    #[Route('/{idTransaction}', name: 'app_transaction_delete', methods: ['POST'])]
    public function delete(Request $request, Transaction $transaction, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transaction->getIdTransaction(), $request->request->get('_token'))) {
            $entityManager->remove($transaction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_transaction_index', [], Response::HTTP_SEE_OTHER);
    }
}