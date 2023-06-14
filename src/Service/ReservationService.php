<?php

namespace App\Service;

use App\Entity\Reservation;
use App\Entity\ReservationItem;
use App\Entity\Schedule;
use App\Entity\Seat;
use App\Repository\PriceRepository;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;


class ReservationService
{
    public function __construct(
        private EntityManagerInterface    $em,
        private ReservationRepository     $reservationRepository,
        private PriceRepository           $priceRepository,
    )
    {
    }

    public function handle($request): void
    {

        $reservation = new Reservation();
        $reservation->setStatus(Reservation::RESERVED);
        $reservation->setSchedule($this->em->getReference(Schedule::class, $request->getScheduleId()));
        $this->prepareReservationItems($request->getReservationItems(), $reservation);
        $this->reservationRepository->prepareData($reservation);
        $this->em->persist($reservation);
        $this->em->flush();
    }

    private function prepareReservationItems($reservationItems, Reservation $reservation): void
    {
        $prices = $this->priceRepository->findAllByName();

        foreach ($reservationItems as $item) {
            $reservationItem = (new ReservationItem())
                ->setSeat($this->em->getReference(Seat::class, $item->getSeat()))
                ->setPrice($prices[$item->getTicketType()]);
            $reservation->addReservationItem($reservationItem);
        }
    }

}