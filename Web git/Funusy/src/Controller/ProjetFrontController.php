<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\QrCode;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;


#[Route('/projet')]
class ProjetFrontController extends AbstractController
{
    #[Route('/f', name: 'app_projet', methods: ['GET'])]
    public function indexFRONT(ProjetRepository $projetRepository, UrlGeneratorInterface $urlGenerator): Response
    {
        $projets = $projetRepository->findAll();
        $qrCodeUrls = [];
        $shareUrls = [];

        foreach ($projets as $projet) {
            // Generate share URLs for social media platforms
            $projectUrl = $urlGenerator->generate('app_projet_detail', ['idProjet' => $projet->getIdProjet()], UrlGeneratorInterface::ABSOLUTE_URL);
            $shareUrls[$projet->getIdProjet()] = [
                'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($projectUrl),
                'twitter' => 'https://twitter.com/intent/tweet?url=' . urlencode($projectUrl) . '&text=' . urlencode($projet->getNomProjet()),
            ];

            // Generate QR codes for each project with all project details
            $details = implode('|', [
                $projet->getIdProjet(),
                $projet->getNomProjet(),
                $projet->getMontantReq(),
                $projet->getDescription(),
            ]);
            $qrCode = new QrCode($details);
            $writer = new PngWriter();
            $qrCodeUrls[$projet->getIdProjet()] = $writer->write($qrCode)->getDataUri();
        }

        return $this->render('projet/indexFRONT.html.twig', [
            'projets' => $projets,
            'qrCodeUrls' => $qrCodeUrls,
            'shareUrls' => $shareUrls,
        ]);
    }



    #[Route('/back', name: 'app_projet_index', methods: ['GET'])]
    public function indexBACK(ProjetRepository $projetRepository): Response
    {
        return $this->render('projet/indexBACK.html.twig', [
            'projets' => $projetRepository->findAll(),
        ]);
    }



    #[Route('/new', name: 'app_projet_new', methods: ['GET', 'POST'])]
    public function createNewProject(Request $request, EntityManagerInterface $entityManager): Response
    {
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($projet);
            $entityManager->flush();

            return $this->redirectToRoute('app_projet_frontend', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('projet/new.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }
    #[Route('/{idProjet}', name: 'app_projet_detail', methods: ['GET'])]
    public function showProjectDetails(Projet $projet): Response
    {
        return $this->render('projet/detail.html.twig', [
            'projet' => $projet,
        ]);
    }
    

    #[Route('/{idProjet}/edit', name: 'app_projet_edit', methods: ['GET', 'POST'])]
    public function editProject(Request $request, Projet $projet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_projet_frontend', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('projet/edit.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    #[Route('/{idProjet}', name: 'app_projet_delete', methods: ['POST'])]
    public function deleteProject(Request $request, Projet $projet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projet->getIdProjet(), $request->request->get('_token'))) {
            $entityManager->remove($projet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_projet_frontend', [], Response::HTTP_SEE_OTHER);
    }
}
