<?php
namespace App\Tests;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class IntegrationTestCase extends KernelTestCase
{
    protected EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        parent::setUp();
        $kernel = self::bootKernel();
        if ('test' !== $kernel->getEnvironment()) {
            throw new \LogicException('Execution only in Test environment possible!');
        }
        $objectManager = static::getContainer()->get('doctrine')->getManager();
        if ($objectManager instanceof EntityManagerInterface) {
            $this->entityManager = $objectManager;
        }
    }
}