<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Post $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Post $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
    * @return Post[] Returns an array of Post objects
    */
    public function searchPost($criteria)
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.categories', 'categorie')
            ->where('categorie.name = :categorieName')
            ->setParameter('categorieName', $criteria['Categorie']->getName())
            ->andWhere('p.author = :author')
            ->setParameter('author', $criteria['author'])
            ->andWhere('p.language = :language')
            ->setParameter('language', $criteria['language'])
            ->getQuery()
            ->getResult()
        ;
    }

    public function getAllFromColumn($columnName)
    {
        $result = $this->createQueryBuilder('p')
            ->select('p.'.$columnName)
            ->getQuery()
            ->getScalarResult();

        return  array_column($result, $columnName);
    }


    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
