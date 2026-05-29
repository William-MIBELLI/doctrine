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

  
  
}