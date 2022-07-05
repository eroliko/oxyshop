<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Enums\HttpStatuses;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserCreateApiController extends AbstractController
{
    public function __construct(
        private readonly ValidatorInterface $validator
    )
    {
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Repository\UserRepository $userRepository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    #[Route(
        '/api/users',
        name: 'api_users',
        methods: ['POST']
    )]
    public function store(Request $request, UserRepository $userRepository): JsonResponse
    {
        $data = \json_decode($request->getContent(), true);
        $user = new User();
        $this->fillUser($user, $data);

        $errors = $this->validator->validate($user);

        if (\count($errors) > 0) {
            $status = HttpStatuses::STATUS_BAD_DATA;
            $response = [
                'errors' => (string)$errors
            ];
        } else {
            $status = HttpStatuses::STATUS_OK;
            // Here could be set User's data as response...
            $response = [];
            $userRepository->add($user, true);
        }

        return new JsonResponse(
            $response,
            $status
        );
    }

    /**
     * @param \App\Entity\User $user
     * @param array $data
     * @return void
     */
    private function fillUser(User $user, array $data): void
    {
        $user->setName($data[User::ATTR_NAME] ?? null);
        $user->setEmail($data[User::ATTR_EMAIL] ?? null);
        $user->setPassword($data[User::ATTR_PASSWORD] ?? null);
        $user->setType(isset($data[User::ATTR_TYPE]) ? (int)$data[User::ATTR_TYPE] : null);
    }
}