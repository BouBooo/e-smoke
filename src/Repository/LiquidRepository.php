<?php

namespace App\Repository;

use App\Entity\Liquid;
use App\Entity\LiquidSearch;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Liquid|null find($id, $lockMode = null, $lockVersion = null)
 * @method Liquid|null findOneBy(array $criteria, array $orderBy = null)
 * @method Liquid[]    findAll()
 * @method Liquid[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LiquidRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Liquid::class);
    }

    public function findLatest()
    {
        return $this->createQueryBuilder('l')
            ->orderBy('l.id', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllQuery()
    {
        return $this->createQueryBuilder('l')
            ->orderBy('l.id', 'DESC')
        ;
    }

    public function findAllParamQuery(LiquidSearch $search)
    {
        $query = $this->findAllQuery();

        if($search->getCategory())
        {
            $query = $query
                    ->andWhere('l.category = :category')
                    ->setParameter('category', $search->getCategory());
        }

        if($search->getMark())
        {
            $query = $query
                    ->andWhere('l.mark = :mark')
                    ->setParameter('mark', $search->getMark());
        }

        return $query->getQuery();

    }

    public function countItems()
    {
        return $this->createQueryBuilder('l')
        ->select('count(l.id)')
        ->orderBy('l.id', 'DESC')
        ->getQuery()
        ->getResult()
        ;
    }



    /*
    public function findOneBySomeField($value): ?Liquid
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
