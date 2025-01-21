<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use App\Service\BadWordsLoader;
use App\Service\GoogleTranslatorService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Form\FormError;

#[Route('/commentaire/front')]
class CommentaireFController extends AbstractController
{


    /**
     * @throws \Exception
     */

    #[Route('/new/front', name: 'app_commentaire_f_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CommentaireRepository $commentaireRepository): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Custom validation to check if the Commentaire already exists
            $existingCommentaire = $commentaireRepository->findOneBy(['contenue' => $commentaire->getContenue()]);
            if ($existingCommentaire !== null) {
                $form->get('contenue')->addError(new FormError('This commentaire already exists.'));
                return $this->renderForm('commentaire_f/new.html.twig', [
                    'commentaire' => $commentaire,
                    'form' => $form,
                ]);
            }

            // Check for bad words
            $commentText = $commentaire->getContenue();
            $badWords = BadWordsLoader::loadBadWords("C:\\Users\\maher\\Downloads\\List.txt");
            foreach ($badWords as $badWord) {
                if (stripos($commentText, $badWord) !== false) {
                    $form->get('contenue')->addError(new FormError('Your comment contains inappropriate words.'));
                    return $this->renderForm('commentaire_f/new.html.twig', [
                        'commentaire' => $commentaire,
                        'form' => $form,
                    ]);
                }
            }

            // If not duplicate, persist the Commentaire entity
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_commentaire', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentaire_f/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }

    #[Route('/{idCommentaire}/front', name: 'app_commentaire_f_show', methods: ['GET'])]
    public function show(Commentaire $commentaire): Response
    {
        return $this->render('commentaire_f/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

    #[Route('/{idCommentaire}/edit/front', name: 'app_commentaire_f_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commentaire', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentaire_f/edit.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form,
        ]);
    }

    #[Route('/{idCommentaire}/front', name: 'app_commentaire_f_delete', methods: ['POST'])]
    public function delete(Request $request, Commentaire $commentaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $commentaire->getIdCommentaire(), $request->request->get('_token'))) {
            $entityManager->remove($commentaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commentaire', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/commentaire/translate/{idCommentaire}', name: 'app_commentaire_translate', methods: ['POST'])]
    public function translate(Request $request, GoogleTranslatorService $translator, int $idCommentaire): Response
    {
        // Retrieve parameters from the request
        $langFrom = 'fr'; // Assuming comments are in French
        $langTo = 'en';   // Target language is English
        $commentText = $request->request->get('comment_text');

        // Call translation service
        $translatedComment = $translator->translate($langFrom, $langTo, $commentText);

        // Return translated comment as JSON response
        return $this->json(['translated_comment' => $translatedComment]);
    }

}
