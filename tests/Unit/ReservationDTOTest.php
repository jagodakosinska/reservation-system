<?php

namespace App\Tests\Unit;

use App\DTO\ReservationDTO;
use App\DTO\ReservationItemsDTO;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 */

class ReservationDTOTest extends TestCase
{

    public function testIfCanCreateDTORequest(): void
    {
        $request = $this->createFromJson();

        $dto = ReservationDTO::fromRequest($request);
        $this->assertEquals(1, $dto->scheduleId);
        $this->assertCount(2, $dto->reservationItems);
        $this->assertInstanceOf(ReservationDTO::class, $dto);
        $this->assertIsArray($dto->reservationItems);
        $this->assertInstanceOf(ReservationItemsDTO::class, $dto->reservationItems[0]);
        $this->assertIsString($dto->reservationItems[0]->ticketType);
        $this->assertContains($dto->reservationItems[0]->ticketType, ['junior', 'adult']);
        $this->assertIsInt($dto->reservationItems[0]->seat);
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