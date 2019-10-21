<?php

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function getList(int $product, string $tri, int $filter = null)
    {
        $dql = 'SELECT r FROM App:Review r WHERE r.product = :product ';

        if (!is_null($filter)) {
            $dql .= 'AND r.note = :filter ';
        }
        if ($tri == 'note') {
            $dql .= 'ORDER BY r.note DESC';
        } else {
            $dql .= 'ORDER BY r.created DESC';
        }

        $query =  $this->getEntityManager()
            ->createQuery($dql)
            ->setParameter('product', $product);

        if (!is_null($filter)) {
            $query->setParameter(':filter', $filter);
        }

        return $query->getArrayResult();
    }

    // /**
    //  * @return Review[] Returns an array of Review objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Review
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
