<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Form\Transaction1Type;
use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\StreamedResponse;
#[Route('/transactionfront')]
class TransactionfrontController extends AbstractController
{
    #[Route('/', name: 'app_transactionfront_index', methods: ['GET'])]
    public function index(TransactionRepository $transactionRepository): Response
    {
        return $this->render('transactionfront/index.html.twig', [
            'transactions' => $transactionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_transactionfront_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,MailerInterface $mailer): Response
    {
        $transaction = new Transaction();
        $form = $this->createForm(Transaction1Type::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($transaction);
            $entityManager->flush();
            if ($transaction->getMontantTransaction() > 1000) {

                $email = (new Email())

                    ->from('bellasfarmalek450@gmail.com')

                    ->to('malek.bellasfar@esprit.tn')

                    ->subject('New transaction created')

                    ->html('<div style="font-family: Arial, sans-serif; color: #444; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
    <h1 style="color: #f00; font-weight: bold;">Important Transaction Alert</h1>
    <p style="font-size: 16px; line-height: 1.5;">A new transaction exceeding the amount of 1000 has been initiated. Please review this transaction as soon as possible.</p>
    <p style="color: #888; font-size: 14px;">Best Regards,</p>
    <p style="color: #888; font-size: 14px;">Funusy Admin Team</p>
     <a href="funusy.com">
    <img src="https://i.ibb.co/bLt0jV1/Asset-1-1.png" alt="Asset-1-1" border="0" width="50"  />
</a>


</div>
');


                $mailer->send($email);

            }
            return $this->redirectToRoute('app_transactionfront_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transactionfront/new.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
        ]);
    }

    #[Route('/{idTransaction}', name: 'app_transactionfront_show', methods: ['GET'])]
    public function show(Transaction $transaction): Response
    {
        return $this->render('transactionfront/show.html.twig', [
            'transaction' => $transaction,
        ]);
    }

    #[Route('/{idTransaction}/edit', name: 'app_transactionfront_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Transaction $transaction, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Transaction1Type::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_transactionfront_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transactionfront/edit.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
        ]);
    }

    #[Route('/{idTransaction}', name: 'app_transactionfront_delete', methods: ['POST'])]
    public function delete(Request $request, Transaction $transaction, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transaction->getIdTransaction(), $request->request->get('_token'))) {
            $entityManager->remove($transaction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_transactionfront_index', [], Response::HTTP_SEE_OTHER);
    }
}
