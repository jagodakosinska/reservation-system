<?php

namespace App\Validator;

use App\DTO\ReservationDTO;
use App\DTO\ReservationItemsDTO;
use App\Repository\ReservationItemRepository;
use App\Repository\ScheduleRepository;
use App\Repository\SeatRepository;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class ReservationConstraintValidator extends ConstraintValidator
{

    public function __construct(
        private ReservationItemRepository $reservationItemRepository,
        private SeatRepository            $seatRepository,
        private ScheduleRepository        $scheduleRepository,
    )
    {
    }

    public const TICKET_TYPES = ['adult', 'junior'];

    /**
     * @inheritDoc
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof ReservationConstraint) {
            throw new UnexpectedTypeException($constraint, ReservationConstraint::class);
        }

        if (!$value instanceof ReservationDTO) {
            throw new UnexpectedTypeException($value, ReservationDTO::class);
        }

        $schedule = $this->scheduleRepository->find($value->scheduleId);
        $seatList = [];
        foreach ($value->reservationItems as $item) {
            if ($item?->seat) {
                $seatList[] = $item->seat;
            }
        }

        $hasSeats = $this->seatRepository->hasSeats($schedule->getScreen()->getId(), $seatList);
        if (false === $hasSeats) {
            $this->context->buildViolation("Seat doesn't exist!")
                ->addViolation();
        }

        $isReserved = $this->reservationItemRepository->checkIsReserved($schedule->getId(), $seatList);
        if ($isReserved) {
            $this->context->buildViolation("Seat is reserved!")
                ->addViolation();
        }

    }
}