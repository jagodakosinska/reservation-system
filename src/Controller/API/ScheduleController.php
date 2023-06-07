<?php

namespace App\Controller\API;

use App\Entity\Schedule;
use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ScheduleController extends AbstractController
{
    #[Route('/api/schedule', name: 'schedules')]
    public function getAllSchedules(ScheduleRepository $scheduleRepository)
    {
        $res = ['schedule' => $scheduleRepository->listAllEvailable()];
        return $this->json($res);
    }

    #[Route('api/schedule/{id}', name: 'schedule')]
    public function getOneById(Schedule $schedule, ScheduleRepository $scheduleRepository)
    {
        $res = ['schedule' => $scheduleRepository->find($schedule->getId())];
        return $this->json($res, 200,[], ['groups' => ['schedule:read']]);
    }

}