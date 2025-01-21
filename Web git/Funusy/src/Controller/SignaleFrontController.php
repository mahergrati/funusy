<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Signale;
use App\Form\SignaleType;
use App\Repository\SignaleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommentaireRepository;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Form\FormError;

#[Route('/signale/front')]
class SignaleFrontController extends AbstractController
{
    #[Route('/front', name: 'app_signale_front_index', methods: ['GET'])]
    public function index(SignaleRepository $signaleRepository, CommentaireRepository $commentaireRepository): Response
    {
        $signales = $signaleRepository->findAll();
        $commentaires = $commentaireRepository->findAll();

        return $this->render('signale_front/index.html.twig', [
            'signales' => $signales,
            'commentaires' => $commentaires, // Pass commentaires to the template
        ]);
    }

    #[Route('/new/front/{commentaireId}', name: 'app_signale_front_new', methods: ['GET', 'POST'])]
    public function new(Request $request, $commentaireId, EntityManagerInterface $entityManager): Response
    {
        // Retrieve the Commentaire entity
        $commentaire = $this->getDoctrine()->getRepository(Commentaire::class)->find($commentaireId);

        // Check if a Signale already exists for this Commentaire
        $existingSignale = $entityManager->getRepository(Signale::class)->findOneBy(['idCommentaire' => $commentaire]);

        // If an existing Signale is found, handle this situation (e.g., redirect or show an error message)
        if ($existingSignale !== null) {
            // Handle the case where a Signale already exists for this Commentaire
            // For example, you could redirect back to the form with an error message
            return $this->redirectToRoute('app_signale_front_index', ['error' => 'A Signale already exists for this Commentaire'], Response::HTTP_SEE_OTHER);
        }

        // Create a new Signale instance and set the Commentaire
        $signale = new Signale();
        $signale->setIdCommentaire($commentaire);

        // Create the Signale form
        $form = $this->createForm(SignaleType::class, $signale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persist the Signale entity
            $entityManager->persist($signale);
            $entityManager->flush();

            return $this->redirectToRoute('app_signale_front_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('signale_front/new.html.twig', [
            'commentaire' => $commentaire,
            'signale' => $signale,
            'form' => $form,
        ]);
    }

    #[Route('/{idSignal}/front/', name: 'app_signale_front_show', methods: ['GET'])]
    public function show(Signale $signale): Response
    {
        return $this->render('signale_front/show.html.twig', [
            'signale' => $signale,
        ]);
    }

    #[Route('/{idSignal}/edit/front/', name: 'app_signale_front_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Signale $signale, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SignaleType::class, $signale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_signale_front_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('signale_front/edit.html.twig', [
            'signale' => $signale,
            'form' => $form,
        ]);
    }

    #[Route('/{idSignal}/front/', name: 'app_signale_front_delete', methods: ['POST'])]
    public function delete(Request $request, Signale $signale, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$signale->getIdSignal(), $request->request->get('_token'))) {
            $entityManager->remove($signale);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_signale_front_index', [], Response::HTTP_SEE_OTHER);
    }
}
