<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    /**
      * @return Produit[] Returns an array of Produit objects
      */

    public function paginate(int $page)
    {
        /* 12 items per page */
        $limit = 12;
        $offset = ( $page - 1 )*$limit;
        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.title', 'ASC')
            ->setMaxResults($limit)
            ->setFirstResult($offset);
        return $qb->getQuery()->getResult();
    }

}
