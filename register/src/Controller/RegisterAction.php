<?php

declare(strict_types=1);

namespace App\Controller;

use App\Http\DTO\RegisterRequest;
use App\Service\RegisterActionService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RegisterAction
{
    public function __construct(RegisterActionService $registerActionService)
    {
        $this->registerActionService = $registerActionService;
    }
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function __invoke(RegisterRequest $registerRequest): JsonResponse
    {
        ($this->registerActionService)($registerRequest->getName(), $registerRequest->getEmail());
        return new JsonResponse();
    }

}