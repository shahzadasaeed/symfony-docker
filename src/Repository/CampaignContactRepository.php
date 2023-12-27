<?php

namespace App\Repository;

use App\Entity\CampaignContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CampaignContact>
 *
 * @method CampaignContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method CampaignContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method CampaignContact[]    findAll()
 * @method CampaignContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CampaignContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CampaignContact::class);
    }

//    /**
//     * @return CampaignContact[] Returns an array of CampaignContact objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CampaignContact
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
