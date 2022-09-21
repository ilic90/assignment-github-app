<?php

namespace App\Repository;

use App\Entity\WordPopularity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WordPopularity>
 *
 * @method WordPopularity|null find($id, $lockMode = null, $lockVersion = null)
 * @method WordPopularity|null findOneBy(array $criteria, array $orderBy = null)
 * @method WordPopularity[]    findAll()
 * @method WordPopularity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WordPopularityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WordPopularity::class);
    }

    public function add(WordPopularity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(WordPopularity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   public function findOneByWordAndProvider(string $word, string $provider): ?WordPopularity
   {
       return $this->createQueryBuilder('wp')
           ->andWhere('wp.word = :word')
           ->andWhere('wp.provider = :provider')
           ->setParameter('word', $word)
           ->setParameter('provider', $provider)
           ->getQuery()
           ->getOneOrNullResult()
       ;
   }
}
