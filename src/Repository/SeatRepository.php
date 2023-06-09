<?php

namespace App\Repository;

use App\Entity\Seat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Seat>
 *
 * @method Seat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Seat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Seat[]    findAll()
 * @method Seat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Seat::class);
    }

    public function save(Seat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Seat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getAvailableBySchedule(int $scheduleId, int $screenId)
    {

        $dql = 'SELECT s FROM App\Entity\Seat s WHERE s.screen= :screenId AND s.id NOT IN
        (SELECT identity(ri.seat) FROM App\Entity\ReservationItem ri 
        JOIN App\Entity\Reservation rs WITH ri.reservation=rs WHERE rs.schedule= :scheduleId)';
        return $this->getEntityManager()->createQuery($dql)
            ->execute(['screenId' => $screenId, 'scheduleId' => $scheduleId]);

    }
}
