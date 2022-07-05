<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route(
        '/users'
        , name: 'app_users',
        methods: ['GET']
    )]
    public function index(FakeUserRoleController $fakeUserRoleController): Response
    {
        return $this->render('users/index.html.twig', [
            'controller_name' => 'UsersController',
            'title' => 'Users',
            'roles' => $fakeUserRoleController->getRoles()
        ]);
    }

    #[Route(
        '/users',
        name: 'app_users_store',
        methods: ['POST']
    )]
    public function store()
    {

    }
}
