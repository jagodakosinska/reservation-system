<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ErrorValidationService
{
    public function handle(ConstraintViolationListInterface $list): Response
    {
        $data = [];
            foreach ($list as $e) {
                $data[] = ['message' => $e->getMessage(), 'details' => $e->getPropertyPath(), 'invalidValue' => $e->getInvalidValue()];
            }
        return new JsonResponse(data: $data, status: Response::HTTP_BAD_REQUEST);
    }
}