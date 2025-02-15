<?php

namespace App\Controller;

use App\Request\GetRatesRequest;
use App\Services\LoadCryptoDataService;
use App\Services\CryptoRateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class CryptoRateController extends AbstractController
{
    public function __construct(
        private readonly CryptoRateService $cryptoRateService
    )
    {
    }

    #[Route('api/rates', methods: ['GET'])]
    public function index(
        #[MapQueryString] GetRatesRequest $getRatesRequest
    ): JsonResponse
    {
        return $this->json($this->cryptoRateService->getCryptoRates($getRatesRequest));
    }

}
