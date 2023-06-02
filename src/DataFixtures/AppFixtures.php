<?php

namespace App\DataFixtures;

use App\Entity\Screen;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
//        AnswerFactory::new(function() use ($questions) {
//        })->needsApproval()->many(20)->create();

        // $product = new Product();
        // $manager->persist($product);
        UserFactory::createOne([
            'email' => 'admin@example.com',
            'password' => 'pass',
            'roles' => ['ROLE_ADMIN'],
            ]);
        UserFactory::createMany(10);

        $screen = (new Screen())->setName('Rainbow')->setNumberOfSeats(500);
        $manager->persist($screen);
        $manager->flush();
    }
}
