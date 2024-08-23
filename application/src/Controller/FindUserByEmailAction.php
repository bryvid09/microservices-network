<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\FindUserByEmailActionService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;

class FindUserByEmailAction
{
    private FindUserByEmailActionService $findUserByEmailActionService;

    public function __construct(FindUserByEmailActionService $findUserByEmailActionService)
    {
        $this->findUserByEmailActionService = $findUserByEmailActionService;
    }

    #[Route('/api/internal/users', name: 'api_internal_get_users', methods: ['GET'])]
    public function __invoke(Request $request): JsonResponse
    {
        if (null === $email = $request->query->get('email')) {
            throw new BadRequestHttpException('Email is required');
        }

        if (null === $user = ($this->findUserByEmailActionService)($email)) {
            throw new NotFoundHttpException(sprintf('User with email %s not found', $email));
        }

        return new JsonResponse($user->toArray());
    }
}