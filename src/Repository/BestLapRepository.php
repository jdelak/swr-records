<?php

namespace App\Repository;

use App\Entity\BestLap;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method BestLap|null find($id, $lockMode = null, $lockVersion = null)
 * @method BestLap|null findOneBy(array $criteria, array $orderBy = null)
 * @method BestLap[]    findAll()
 * @method BestLap[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BestLapRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, BestLap::class);
    }

    public function findFilter($filter)
    {
        
        $query = $this->createQueryBuilder('b');
        $query->join('b.racer', 'r');
        $query->join('b.race', 'ra');
        $query->join('b.player', 'p');

        if(!empty($filter["'racer'"])){
            $query->andWhere('r.name = :racer')
            ->setParameter('racer', $filter["'racer'"]);
        }
        if(!empty($filter["'race'"])){
            $query->andWhere('ra.name = :race')
            ->setParameter('race', $filter["'race'"]);
        }
        if(!empty($filter["'player'"])){
            $query->andWhere('p.username like :player')
            ->setParameter('player', $filter["'player'"].'%');
        }
        $query->orderBy('b.id','DESC');

        return $query->getQuery()->getResult();

    }
    
    public function findAllDesc(){
        return $this->createQueryBuilder('b')
            ->orderBy('b.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByPlayer($user){
        return $this->createQueryBuilder('b')
            ->join('b.player', 'p')
            ->andWhere('p.id = :user')
            ->setParameter('user', $user)
            ->orderBy('b.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
    
    public function getNbBestLaps()
    {
        return $this->createQueryBuilder('b')
            ->select('COUNT(b.id) AS nombre')
            ->getQuery()
            ->getSingleScalarResult()
        ;
    }

    
    // /**
    //  * @return BestLap[] Returns an array of BestLap objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BestLap
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
