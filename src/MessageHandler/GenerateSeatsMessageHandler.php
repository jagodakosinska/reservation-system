<?php

namespace App\MessageHandler;

use App\Entity\Screen;
use App\Entity\Seat;
use App\Message\GenerateSeatsMessage;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class GenerateSeatsMessageHandler
{

    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function __invoke(GenerateSeatsMessage $message)
    {
        $screens = $this->em->getRepository(Screen::class)->findAll();
        foreach ($screens as $screen) {
            $seatsNumbers = $screen->getNumberOfSeats();
            $cnt = $this->em->getRepository(Seat::class)->count(['screen' => $screen]);
            $toGenerate = $seatsNumbers - $cnt;
            for ($i = 1; $i <= $toGenerate; $i++) {
                $seat = (new Seat())->setScreen($screen)->setNumber($cnt + $i);
                $this->em->persist($seat);
            }
        }
        $this->em->flush();
    }
}
