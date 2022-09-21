<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Request\GetScoreQueryParams;
use App\Service\WordPopularity\WordPopularityService;

class ScoreController extends AbstractController
{
    private ValidatorInterface $validator;
    private WordPopularityService $wordPopularityService;

    public function __construct(ValidatorInterface $validator, WordPopularityService $wordPopularityService)
    {
        $this->validator = $validator;
        $this->wordPopularityService = $wordPopularityService;
    }

    #[Route('/score', name: 'score', methods: ['GET', 'HEAD'])]
    public function getScore(Request $request): JsonResponse
    {
        $queryParams = new GetScoreQueryParams($request);

        $errors = $this->validator->validate($queryParams);
        
        if(count($errors) > 0) {
            return $this->json(['errors' => (string) $errors], 422);
        }

        $word = $queryParams->getTerm();

        $this->wordPopularityService->setWord($word);
        $wordPopularityScore = $this->wordPopularityService->getPopularityScore();

        return $this->json([
            'term' => $word,
            'score' => $wordPopularityScore
        ]);
    }
}