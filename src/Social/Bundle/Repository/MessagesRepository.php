<?php

namespace Social\Bundle\Repository;

/**
* MessagesRepository
*
* This class was generated by the Doctrine ORM. Add your own custom
* repository methods below.
*/
class MessagesRepository extends \Doctrine\ORM\EntityRepository
{
  public function findConversation($emetteur, $recepteur){
    $qb = $this->createQueryBuilder('m');
    $qb->where('m.emetteur = :emetteur AND m.recepteur= :recepteur')
    ->orWhere('m.emetteur = :recepteur AND m.recepteur= :emetteur')
    ->setParameter('emetteur', $emetteur)
    ->setParameter('recepteur', $recepteur)
    ;
    return $qb
    ->getQuery()
    ->getResult()
    ;
  }

}
