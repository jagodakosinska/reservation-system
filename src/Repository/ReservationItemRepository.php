<?php

namespace App\Repository;

use App\Entity\ReservationItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReservationItem>
 *
 * @method ReservationItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReservationItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReservationItem[]    findAll()
 * @method ReservationItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReservationItem::class);
    }

    public function save(ReservationItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ReservationItem $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function checkIsReserved(int $scheduleId, array $seatList): bool
    {
        $result = $this->createQueryBuilder('ri')
            ->select('count(ri)')
            ->join('ri.reservation', 'r')
            ->andWhere('ri.seat in (:seatList) and r.schedule = :scheduleId')
            ->setParameter('seatList', $seatList)
            ->setParameter('scheduleId', $scheduleId)
            ->getQuery()
            ->getSingleScalarResult();

        return $result !== 0;
    }
}
