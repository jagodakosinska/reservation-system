<?php

namespace App\Controller\API;

use App\Entity\Schedule;
use App\Repository\ScheduleRepository;
use App\Repository\SeatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/schedule', name: 'schedule_', methods: 'GET')]
class ScheduleController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function getAll(ScheduleRepository $scheduleRepository): Response
    {
        $res = ['schedule' => $scheduleRepository->listAllAvailable()];
        return $this->json($res);
    }

    #[Route('/{id}', name: 'show')]
    public function getOneById(Schedule $schedule, SeatRepository $seatRepository): Response
    {
        $list = $seatRepository->getAvailableBySchedule($schedule->getId(), $schedule->getScreen()->getId());
        $res = ['schedule' => $schedule,
            'seats' => $list];
        return $this->json($res, 200,[], ['groups' => ['schedule:read','schedule:reservation']]);
    }

}