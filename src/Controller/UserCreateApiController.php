<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Enums\HttpStatuses;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCreateApiController extends AbstractController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Repository\UserRepository $userRepository
     * @param \Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    #[Route(
        '/api/users',
        name: 'api_users_create',
        methods: ['POST']
    )]
    public function store(
        Request $request,
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordEncoder
    ): JsonResponse
    {
        $user = new User();

        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        // If the request comes from external source (Postman)...
        if (! $form->isSubmitted()) {
            $data = \json_decode($request->getContent(), true);
            $form->submit($data);
        }

        if ($form->isValid()) {
            $user->setPassword(
                $passwordEncoder->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $status = HttpStatuses::STATUS_OK;
            // Here could be set User's data as response...
            $response = [];
            $userRepository->add($user, true);
        } else {
            $errors = [];

            /** @var \Symfony\Component\Form\FormError $error */
            foreach ($form->getErrors(true) as $error) {
                /** @var \Symfony\Component\Validator\ConstraintViolation $cause */
                $cause = $error->getCause();
                $errors[$cause->getPropertyPath()] = $error->getMessage();
            }

            $status = HttpStatuses::STATUS_BAD_DATA;
            $response = [
                $errors
            ];
        }

        return new JsonResponse(
            $response,
            $status
        );
    }
}