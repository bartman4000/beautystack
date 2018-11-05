<?php

namespace App\Repository;

use App\Entity\Style;
use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Style|null find($id, $lockMode = null, $lockVersion = null)
 * @method Style|null findOneBy(array $criteria, array $orderBy = null)
 * @method Style[]    findAll()
 * @method Style[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StyleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Style::class);
    }

    /**
    * @return Style[] Returns an array of Style objects
    */
    public function findByWord(string $word)
    {
        $qb = $this->createQueryBuilder('s');
        $results = $qb
            ->where($qb->expr()->orX(
                $qb->expr()->like('s.name', $qb->expr()->literal("%{$word}%")),
                $qb->expr()->like('s.description', $qb->expr()->literal("%{$word}%"))
            ))
            ->andWhere('s.deleted = :val')
            ->setParameter('val', 0)
            ->getQuery()
            ->getResult();

        $tagResults = $this->findByTag($word);

        return array_unique(array_merge($results, $tagResults), SORT_REGULAR);
    }

    public function findByTag(string $word)
    {
        $repo = $this->getEntityManager()->getRepository(Tag::class);
        /** @var Tag $tag */
        $tag = $repo->findOneBy(['tag' => $word]);
        if ($tag) {
            $tag_id = $tag->getId();
            $qb = $this->createQueryBuilder('s');
            return $qb->where(':tag MEMBER OF s.tags')->setParameter('tag', $tag_id)
                ->andWhere('s.deleted = :val')
                ->setParameter('val', 0)
                ->getQuery()
                ->getResult();
        }

        return [];
    }
}
