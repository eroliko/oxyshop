<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Enums\HttpStatuses;
use App\Form\UserFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Twig\Environment;

class UsersController extends AbstractController
{
    /**
     * @param \App\Controller\FakeUserRoleController $fakeUserRoleController
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route(
        '/users'
        , name: 'app_users',
        methods: ['GET']
    )]
    public function index(FakeUserRoleController $fakeUserRoleController, Environment $twig): Response
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);
        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
            'title' => 'Users',
            'roles' => $fakeUserRoleController->getRoles(),
            'user_form' => $form->createView()
        ]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Contracts\HttpClient\HttpClientInterface $client
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    #[Route(
        '/users',
        name: 'app_users_store',
        methods: ['POST']
    )]
    public function store(
        Request $request,
        HttpClientInterface $client
    ): RedirectResponse
    {
        // Normally $request->request->all() is unsecured, but this code is only faking AJAX call,
        // so the validation etc. is in actual EP...
        // URL http://nginx is set because of docker containers, see https://www.youtube.com/watch?v=1cDXJq_RyNc
        try {
            $response = $client->request(
                'POST',
                'http://nginx/api/users',
                [
                    'body' => $request->request->all()
                ]
            );

            if ($response->getStatusCode() === HttpStatuses::STATUS_OK) {
                $this->addFlash('success', 'User registered!');
            } else {
                // Format would depend on FE...
                foreach (\json_decode($response->getContent(false), true) as $error) {
                    $this->addFlash('error', $error);
                }
            }
        } catch (
            ClientExceptionInterface
            |RedirectionExceptionInterface
            |ServerExceptionInterface
            |TransportExceptionInterface $e
        ) {
            $this->addFlash('error', [
                'NetworkError' => $e->getMessage()
            ]);
        }

        return $this->redirectToRoute('app_users');
    }
}
