<?php

namespace App\Repository;

use App\Entity\Consultation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Consultation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Consultation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Consultation[]    findAll()
 * @method Consultation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsultationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Consultation::class);
    }

    public function listconsultation(){
        $entityManager = $this->getEntityManager();
        
        $query = $entityManager->createQuery(
                'SELECT c
                FROM App\Entity\Consultation c
                WHERE c.patient is null
                ORDER BY c.creneau ASC'
                );
                
                return $query->execute();
    }

    public function consultationByDentiste($d){
        $entityManager = $this->getEntityManager();
        
        $query = $entityManager->createQuery(
                'SELECT c
                FROM App\Entity\Consultation c
                WHERE c.dentiste = :d
                ORDER BY c.creneau ASC'
                )->setParameter('d', $d);
                
                return $query->execute();
    }

    public function consultationByPatient($p){
        $entityManager = $this->getEntityManager();
        
        $query = $entityManager->createQuery(
                'SELECT c
                FROM App\Entity\Consultation c
                WHERE c.patient = :p
                ORDER BY c.creneau ASC'
                )->setParameter('p', $p);
                
                return $query->execute();
    }


    // /**
    //  * @return Consultation[] Returns an array of Consultation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Consultation
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
