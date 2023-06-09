<?php

namespace App\Controller\API;

use App\Repository\ReservationRepository;
use App\Service\ReservationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/reservation', name: 'reservation_')]
class ReservationController extends AbstractController
{

    #[Route('/', name: 'list')]
    public function getAll(ReservationRepository $reservationRepository): Response
    {
        return $this->json($reservationRepository->listAll());

    }

    #[Route('/create', name: 'new')]
    public function create(Request $request, ReservationService $reservationService): Response
    {
        $reservationService->handleReservation($request);

        return $this->json(['status' => 'success']);

    }
}