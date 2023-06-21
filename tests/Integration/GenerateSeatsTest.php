<?php

namespace App\Tests\Integration;

use App\Entity\Screen;
use App\Entity\Seat;
use App\Message\GenerateSeatsMessage;
use App\MessageHandler\GenerateSeatsMessageHandler;
use App\Tests\IntegrationTestCase;


class GenerateSeatsTest extends IntegrationTestCase
{
    public function testCountGeneratedSeats()
    {
        // Given
        /**
         * @var Screen $screen
         */
        $screen = $this->entityManager->getRepository(Screen::class)->findOneBy(['name' => 'Rainbow']);
        $beforeCount = $this->entityManager->getRepository(Seat::class)->count(['screen' => $screen]);
        $this->assertLessThan($screen->getNumberOfSeats(), $beforeCount);

        // When
        $message = new GenerateSeatsMessage();
        $messageHandler = new GenerateSeatsMessageHandler($this->entityManager);
        $messageHandler($message);

        // Then
              $afterCount = $this->entityManager->getRepository(Seat::class)->count(['screen' => $screen]);
        $this->assertEquals($screen->getNumberOfSeats(), $afterCount);
    }

}