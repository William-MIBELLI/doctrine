<?php

namespace App\Repositories;

use Doctrine\ORM\EntityRepository;

class InvestigatorAvailabilityRepository extends EntityRepository
{
  public function getAllInvestigatorAvailabilities()
  {
    return $this->findAll();
  }
}