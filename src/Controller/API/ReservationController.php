<?php

namespace App\Controller\API;

use App\DTO\ReservationDTO;
use App\Repository\ReservationRepository;
use App\Service\ErrorValidationService;
use App\Service\ReservationService;
use App\Validator\ReservationConstraint;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/reservation', name: 'reservation_')]
class ReservationController extends AbstractController
{

    #[Route('/', name: 'list')]
    public function getAll(ReservationRepository $reservationRepository): Response
    {
        return $this->json($reservationRepository->listAll());

    }

    #[Route('/create', name: 'new')]
    public function create(
        Request                $request,
        ValidatorInterface     $validator,
        ReservationConstraint  $constraints,
        ErrorValidationService $errorValidationService,
        ReservationService     $reservationService
    ): Response
    {
        $reservationDTO = ReservationDTO::fromRequest($request->toArray());
        $errors = $validator->validate(value: $reservationDTO);

        if ($errors->count() == 0) {
            $errors = $validator->validate(value: $reservationDTO, constraints: $constraints);
        }
        if ($errors->count()) {
            return $errorValidationService->handle($errors);
        }

        $reservationService->handle($reservationDTO);

        return $this->json(['status' => 'success']);

    }
}