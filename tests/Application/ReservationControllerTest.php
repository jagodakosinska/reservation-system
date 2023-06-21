<?php

namespace App\Tests\Application;

use App\Tests\ServiceTestCase;

class ReservationControllerTest extends ServiceTestCase
{
    // TODO
    public function testGetReservationList(): void
    {

        $crawler = $this->client->request('GET', '/api/reservation/');
        $this->assertResponseStatusCodeSame(200);
    }

}