<?php

namespace App\Repositories;

use App\Entities\ShopAvaibility;
use Doctrine\ORM\EntityRepository;

class ShopAvailabilityRepository extends EntityRepository
{

  /**
   * Summary of getAllAvailabilities
   * @return ShopAvaibility[]
   */
  public function getAllAvailabilities(): array
  {
    return $this->findAll();
  }
}