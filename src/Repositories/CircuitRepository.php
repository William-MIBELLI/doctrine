<?php

namespace App\Repositories;

use App\Entities\Circuit;
use Doctrine\ORM\EntityRepository;

class CircuitRepository extends EntityRepository
{

  /**
   * Summary of findAllCircuits
   * @return Circuit[]
   */
  public function findAllCircuits()
  {
    return $this->findAll();
  }

  /**
   * Summary of findCircuitsWithFilters
   * @param int|null $investigatorId
   * @return Circuit[]
   */
  public function findCircuitsWithFilters(?int $investigatorId): array
  {
    $qb = $this->createQueryBuilder('c');

    if ($investigatorId) {
      $qb->where('c.investigator = :investigatorId')->setParameter('investigatorId', $investigatorId);
    }

    $res = $qb->getQuery()->getResult();

    return $res;
  }

  public function findCircuitById(int $id): Circuit|null
  {
    return $this->findOneBy(['id' => $id]);
  }

}