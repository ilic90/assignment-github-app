<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Request\GetScoreQueryParams;
use App\Response\ScoreResponse;
use App\Service\WordPopularity\WordPopularityService;
use OpenApi\Attributes as OA;

#[Route('/api', name: 'api_')]
class ScoreController extends JsonApiController
{
    private ValidatorInterface $validator;
    private WordPopularityService $wordPopularityService;

    public function __construct(ValidatorInterface $validator, WordPopularityService $wordPopularityService)
    {
        $this->validator = $validator;
        $this->wordPopularityService = $wordPopularityService;
    }

    #[Route('/score', name: 'score', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Returns the popularity score for given term.',
        content: new OA\JsonContent(
            type: 'object',
            default: new ScoreResponse('php', 34.17)
        )
    )]
    #[OA\Parameter(
        name: 'term',
        in: 'query',
        description: 'The field used for popularity score calculation.',
        required: true,
        schema: new OA\Schema(type: 'string')
    )]
    public function getScore(Request $request): JsonResponse
    {
        $queryParams = new GetScoreQueryParams($request);

        $errors = $this->validator->validate($queryParams);
        
        if(count($errors) > 0) {
            return $this->jsonFailResponse($this->formatErrors($errors), 422);
        }

        $word = $queryParams->getTerm();

        $this->wordPopularityService->setWord($word);
        $wordPopularityScore = $this->wordPopularityService->getPopularityScore();

        return $this->jsonSuccessResponse(new ScoreResponse($word, $wordPopularityScore));
    }
}