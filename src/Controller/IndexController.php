<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    #[Route(
        '/',
        name: 'app_index',
        methods: ['GET']
    )]
    public function index(): RedirectResponse
    {
        return $this->redirectToRoute('app_users_register');
    }
}