<?php

namespace App\DTO;

use App\Entity\Price;
use App\Entity\Seat;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as CRValidator;

class ReservationItemsDTO
{
    #[Assert\Sequentially([
        new Assert\NotBlank,
        new Assert\Type(type: 'integer', message: 'Seat must be type of integer'),
        new CRValidator\EntityExistsConstraint(payload: Seat::class)
    ])]
    public $seat;

    #[Assert\Sequentially([
        new Assert\NotBlank,
        new Assert\Type(type: 'string', message: 'TicketType must be type of string'),
        new CRValidator\EntityExistsConstraint(payload: [Price::class, 'name'])
    ])]
    public $ticketType;

    /**
     * @return mixed
     */
    public function getSeat()
    {
        return $this->seat;
    }

    /**
     * @return mixed
     */
    public function getTicketType()
    {
        return $this->ticketType;
    }

    public static function fromRequest(array $item): self
    {
        $dto = new self();
        if (isset($item['seat'])) {
            $dto->seat = $item['seat'];
        }
        if (isset($item['ticketType'])) {
            $dto->ticketType = $item['ticketType'];
        }
        return $dto;
    }
}