<?php

namespace App\Repository;

use App\Entity\Skin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Skin>
 */
class SkinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Skin::class);
    }

    public function save(Skin $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Skin $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByChampion(int $championId): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.champion = :championId')
            ->andWhere('s.status = :status')
            ->setParameter('championId', $championId)
            ->setParameter('status', 'published')
            ->orderBy('s.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findBySeller(string $sellerId): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.seller = :sellerId')
            ->andWhere('s.status = :status')
            ->setParameter('sellerId', $sellerId)
            ->setParameter('status', 'published')
            ->orderBy('s.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByCategory(int $categoryId): array
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.categories', 'c')
            ->where('c.id = :categoryId')
            ->andWhere('s.status = :status')
            ->setParameter('categoryId', $categoryId)
            ->setParameter('status', 'published')
            ->orderBy('s.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findPublishedSkins(): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.status = :status')
            ->setParameter('status', 'published')
            ->orderBy('s.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findFeaturedSkins(int $limit = 6): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.status = :status')
            ->setParameter('status', 'published')
            ->orderBy('s.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function searchSkins(string $query): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.status = :status')
            ->andWhere('s.title LIKE :query OR s.description LIKE :query')
            ->setParameter('status', 'published')
            ->setParameter('query', '%' . $query . '%')
            ->orderBy('s.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
