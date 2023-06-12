<?php

namespace App\Service;

use App\Entity\Reservation;
use App\Entity\ReservationItem;
use App\Entity\Schedule;
use App\Entity\Seat;
use App\Repository\PriceRepository;
use App\Repository\ReservationItemRepository;
use App\Repository\ReservationRepository;
use App\Repository\ScheduleRepository;
use App\Repository\SeatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;


class ReservationService
{
    public function __construct(
        private EntityManagerInterface    $em,
        private ScheduleRepository        $scheduleRepository,
        private ReservationRepository     $reservationRepository,
        private PriceRepository           $priceRepository,
        private ReservationItemRepository $reservationItemRepository,
        private SeatRepository            $seatRepository
    )
    {
    }

    public function handle($request): void
    {
        $this->validate($request);
        $reservation = new Reservation();
        $reservation->setStatus(Reservation::RESERVED);
        $reservation->setSchedule($this->em->getReference(Schedule::class, $request->getScheduleId()));
        $this->prepareReservationItems($request->getReservationItems(), $reservation);
        $this->reservationRepository->prepareData($reservation);
        $this->em->persist($reservation);
        $this->em->flush();
    }

    public function validate($request): void
    {
        $schedule = $this->scheduleRepository->find($request->getScheduleId());
        if (null === $schedule) {
            throw new BadRequestException(sprintf("Schedule %d doesn't exist!", $request->getScheduleId()));
        }

        $seatList = array_column($request->getReservationItems(), 'seat');
        $hasSeats = $this->seatRepository->hasSeats($schedule->getScreen()->getId(), $seatList);
        if (false === $hasSeats) {
            throw new BadRequestException("Seat doesn't exist!");
        }

        $isReserved = $this->reservationItemRepository->checkIsReserved($schedule->getId(), $seatList);

        if ($isReserved) {
            throw new BadRequestException("Seat is reserved!");
        }
    }

    private function prepareReservationItems($reservationItems, Reservation $reservation): void
    {
        $prices = $this->priceRepository->findAllByName();

        foreach ($reservationItems as $item) {
            $reservationItem = (new ReservationItem())
                ->setSeat($this->em->getReference(Seat::class, $item['seat']))
                ->setPrice($prices[$item['ticketType']]);
            $reservation->addReservationItem($reservationItem);
        }
    }

}