<?php

namespace App\Controller;

use App\Entity\Agence;
use App\Form\Agence1Type;
use App\Repository\AgenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/agence/front')]
class AgenceFrontController extends AbstractController
{
    #[Route('/', name: 'app_agence_front_index', methods: ['GET'])]
    public function index(AgenceRepository $agenceRepository): Response
    {
        return $this->render('agence_front/index.html.twig', [
            'agences' => $agenceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_agence_front_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $agence = new Agence();
        $form = $this->createForm(Agence1Type::class, $agence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($agence);
            $entityManager->flush();

            return $this->redirectToRoute('app_agence_front_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('agence_front/new.html.twig', [
            'agence' => $agence,
            'form' => $form,
        ]);
    }

    #[Route('/{codeAgence}', name: 'app_agence_front_show', methods: ['GET'])]
    public function show(Agence $agence): Response
    {
        return $this->render('agence_front/show.html.twig', [
            'agence' => $agence,
        ]);
    }

    #[Route('/{codeAgence}/edit', name: 'app_agence_front_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Agence $agence, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Agence1Type::class, $agence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_agence_front_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('agence_front/edit.html.twig', [
            'agence' => $agence,
            'form' => $form,
        ]);
    }

    #[Route('/{codeAgence}', name: 'app_agence_front_delete', methods: ['POST'])]
    public function delete(Request $request, Agence $agence, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$agence->getCodeAgence(), $request->request->get('_token'))) {
            $entityManager->remove($agence);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_agence_front_index', [], Response::HTTP_SEE_OTHER);
    }
}
