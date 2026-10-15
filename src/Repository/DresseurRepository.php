<?php

namespace App\Repository;

use App\Entity\Dresseur;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Dresseur>
 */
final class DresseurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dresseur::class);
    }

    /**
     * @return list<Dresseur>
     */
    public function findAllForUser(User $user): array
    {
        return $this->createQueryBuilder('dresseur')
            ->addSelect('pokemon')
            ->leftJoin('dresseur.pokemon', 'pokemon')
            ->andWhere('dresseur.user = :user')
            ->setParameter('user', $user)
            ->orderBy('dresseur.id', 'ASC')
            ->addOrderBy('pokemon.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
