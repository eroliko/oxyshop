<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UsersShowApiController extends AbstractController
{
    #[Route(
        '/api/users',
        name: 'api_users_show',
        methods: ['GET']
    )]
    public function show(UserRepository $userRepository): JsonResponse
    {
        return new JsonResponse(
            $userRepository->findAllAsArray()
        );
    }
}