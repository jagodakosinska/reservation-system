<?php

namespace App\DTO;

use App\Entity\Schedule;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as CRValidator;

class ReservationDTO
{
    #[Assert\Sequentially([
        new Assert\NotBlank,
        new Assert\Type(type: 'integer', message: 'Schedule must be type of integer'),
        new CRValidator\EntityExistsConstraint(payload: Schedule::class)
    ])]
    public $scheduleId;

    /**
     * @return mixed
     */
    public function getScheduleId()
    {
        return $this->scheduleId;
    }

    /**
     * @return array
     */
    public function getReservationItems(): array
    {
        return $this->reservationItems;
    }

    #[Assert\Valid]
    #[Assert\NotBlank]
    #[Assert\Count(
        min: 1,
        minMessage: 'You must specify at least one seat'
    )]
    public $reservationItems = [];

    public static function fromRequest(array $request): self
    {
        $dto = new self();
        if (isset($request['scheduleId'])) {
            $dto->scheduleId = $request['scheduleId'];
        }

        if (isset($request['reservationItems'])) {
            foreach ($request['reservationItems'] as $item) {
                $dto->reservationItems[] = ReservationItemsDTO::fromRequest($item);
            }
        }
        return $dto;
    }

}