<?php

namespace AppBundle\Repository;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;

class UsuarioRepository extends \Doctrine\ORM\EntityRepository {

    public function loadUserByUsername($iup) {
        return $this->createQueryBuilder('u')
                        ->where('u.fechaBaja IS NULL')
                        ->andWhere('u.iup = :iup')
                        ->setParameter('iup', $iup)
                        ->getQuery()
                        ->getOneOrNullResult();
    }

}