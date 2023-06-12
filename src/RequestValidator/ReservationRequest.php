<?php

namespace App\RequestValidator;

use DigitalRevolution\SymfonyRequestValidation\AbstractValidatedRequest;
use DigitalRevolution\SymfonyRequestValidation\Renderer\ViolationListRenderer;
use DigitalRevolution\SymfonyRequestValidation\ValidationRules;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ReservationRequest extends AbstractValidatedRequest
{
    protected function getValidationRules(): ValidationRules
    {
        return new ValidationRules([
            'request' => [
                'scheduleId'   => 'required|int|min:0',
                'reservationItems.*.seat' =>'required|int',
                'reservationItems.*.ticketType' =>'required|string',
            ]
        ]);
    }

    public function getScheduleId(): int
    {
        return $this->request->request->getInt('scheduleId');
    }

    public function getReservationItems(): ?array
    {
        return $this->request->get('reservationItems');
    }


}