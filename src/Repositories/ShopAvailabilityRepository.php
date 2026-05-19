<?php

namespace App\Repositories;

use App\Entities\ShopAvailability;
use Doctrine\ORM\EntityRepository;

class ShopAvailabilityRepository extends EntityRepository
{

  /**
   * Summary of getAllAvailabilities
   * @return ShopAvailability[]
   */
  public function getAllAvailabilities(): array
  {
    return $this->findAll();
  }
}