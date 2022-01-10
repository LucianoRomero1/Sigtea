<?php

namespace AppBundle\Repository;

/**
 * DomicilioRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DomicilioRepository extends \Doctrine\ORM\EntityRepository
{
    public function findDomicilio($empresa,$tipo)
    {
        $selectDomicilio = $this->createQueryBuilder('d')
            ->where('d.tipo = :tipo');
        if($tipo == 3){
            $selectDomicilio->andWhere('d.zonificacion IS NOT NULL');            
        }
        return $selectDomicilio->andWhere('d.empresa = :empresa')
            ->setParameter(':empresa', $empresa)
            ->setParameter(':tipo', $tipo)
            ->orderBy('d.id','DESC')
            ->setMaxResults( 1 )
            ->getQuery()
            ->execute();
    }
}
