<?php

namespace App\DataFixtures;


use App\Entity\Price;
use App\Entity\ReservationItem;
use App\Entity\Schedule;
use App\Entity\Screen;
use App\Entity\Seat;
use App\Factory\PriceFactory;
use App\Factory\ReservationFactory;
use App\Factory\ReservationItemFactory;
use App\Factory\ScheduleFactory;
use App\Factory\ScreenFactory;
use App\Factory\SeatFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {

        $screen = (new Screen())->setName('Rainbow')->setNumberOfSeats(200);
        $manager->persist($screen);

        for ($i = 1; $i <= 100; $i++) {
            $seat = (new Seat())->setScreen($screen)->setNumber($i);
            $manager->persist($seat);
        }

        $manager->persist($this->buildPrice(name: 'junior', amount: 15));
        $manager->persist($this->buildPrice(name: 'adult', amount: 25));

        $manager->persist(
            (new Schedule())
            ->setScreen($screen)
            ->setStartTime(new \DateTime('2023-06-31 10:30:00'))
            ->setEndTime(new \DateTime('2023-06-31 12:30:00'))
            ->setTitle('avatar'));

        $manager->flush();
    }

    private function buildPrice(string $name, int $amount): Price
    {
        return (new Price())->setName($name)->setAmount($amount);

    }
}
