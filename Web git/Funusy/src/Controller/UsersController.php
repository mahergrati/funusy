<?php

namespace App\Controller;

use App\Form\CheckResetType;
use App\Form\User1Type;
use App\Form\UserType;

use Symfony\Component\HttpFoundation\JsonResponse;
use App\Form\ChangePasswordFormType;
use App\Entity\User;
use App\Form\Signup1Type;
use App\Form\Signup2Type;
use App\Form\Signup3Type;
use App\Form\UserLoginFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Gregwar\Captcha\CaptchaBuilder;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
// Add this at the beginning of your UserController.php file
use Symfony\Component\Form\FormError;

#[Route('/users')]
class UsersController extends AbstractController
{
    #[Route('/', name: 'app_users_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        $maxPerPage = 5;
        return $this->render('users/index.html.twig', [
            'maxPerPage' => $maxPerPage,
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_users_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('users/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id_user}', name: 'app_users_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('users/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id_user}/edit', name: 'app_users_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('users/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id_user}', name: 'app_users_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_users_index', [], Response::HTTP_SEE_OTHER);
    }
    public function statistics(UserRepository $userRepository): JsonResponse
{
    // Count admins and clients
    $adminsCount = $userRepository->countByRole('ADMIN');
    $clientsCount = $userRepository->countByRole('CLIENT');

    // Calculate average salary by age group
    $averageSalariesByAgeGroup = $userRepository->averageSalariesByAgeGroup();

    return $this->json([
        'admins_count' => $adminsCount,
        'clients_count' => $clientsCount,
        'average_salaries_by_age_group' => $averageSalariesByAgeGroup,
    ]);
}
}
