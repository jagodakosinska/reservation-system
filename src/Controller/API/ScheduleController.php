<?php

namespace App\Controller\API;

use App\Entity\Schedule;
use App\Repository\ScheduleRepository;
use App\Repository\SeatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ScheduleController extends AbstractController
{
    #[Route('/api/schedule', name: 'all_schedules')]
    public function getAllSchedules(ScheduleRepository $scheduleRepository)
    {
        $res = ['schedule' => $scheduleRepository->listAllEvailable()];
        return $this->json($res);
    }

    #[Route('api/schedule/{id}', name: 'schedule')]
    public function getOneById(Schedule $schedule, SeatRepository $seatRepository)
    {
        $list = $seatRepository->getAvailableBySchedule($schedule->getId(), $schedule->getScreen()->getId());
        $res = ['schedule' => $schedule,
            'seats' => $list];
        return $this->json($res, 200,[], ['groups' => ['schedule:read','schedule:reservation']]);
    }

}