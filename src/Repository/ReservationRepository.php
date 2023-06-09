<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 *
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function save(Reservation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Reservation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function prepareData(Reservation $entity):void
    {
        $this->calculate($entity);
        $this->setValidDate($entity);
    }

    private function calculate(Reservation $entity): void
    {
        $sum = 0;
        foreach ($entity->getReservationItems() as $item) {
            $sum += $item->getPrice()->getAmount();
        }
        $entity->setTotalPrice($sum);
    }

    private function setValidDate(Reservation $entity): void
    {
        $validDate = $entity->getSchedule()->getStartTime()->modify('-30 min');
        $entity->setValidDate($validDate);
    }

    public function listAll(): array
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getArrayResult();
    }
}
