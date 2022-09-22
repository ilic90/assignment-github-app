<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class JsonApiController extends AbstractController
{
    const CONTENT_TYPE = 'application/vnd.api+json';

    protected function jsonSuccessResponse(mixed $data, mixed $meta = null, int $status = 200): JsonResponse
    {
        return $this->json(
            [
                'data' => $data,
                'meta' => $meta ?? new \ArrayObject()
            ],
            $status,
            ['Content-Type' => self::CONTENT_TYPE]
        );
    }

    protected function jsonFailResponse(mixed $errors, int $status = 400): JsonResponse
    {
        return $this->json(
            ['errors' => $errors],
            $status,
            ['Content-Type' => self::CONTENT_TYPE]
        );
    }

    protected function formatErrors(ConstraintViolationListInterface $errors): array
    {
        $formattedErrors = [];

        foreach($errors as $error) {
            $formattedErrors[] = [
                'title' => $error->getMessage(),
                'source' => [
                    'parameter' => $error->getPropertyPath()
                ]
            ];
        }

        return $formattedErrors;
    }
}