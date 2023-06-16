<?php

namespace App\Tests\Unit;

use App\DTO\ReservationDTO;
use PHPUnit\Framework\TestCase;

class ReservationDTOTest extends TestCase
{

    public function testIfCanCreateDTORequest(): void
    {
        $request = $this->createFromJson();

        $dto = ReservationDTO::fromRequest($request);
        $this->assertEquals(1, $dto->scheduleId);
        $this->assertCount(2, $dto->reservationItems);
        $this->assertInstanceOf(ReservationDTO::class, $dto);

    }

    private function createFromJson()
    {
        return json_decode('{
        "scheduleId": 1,
        "reservationItems": [
            {
                "seat":1698,
                "ticketType": "junior"
            },
            {
                "seat": 1699, 
                "ticketType": "adult"
            }
        ]
    }', true);
    }


}