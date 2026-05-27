<?php

namespace App\Repositories;

use App\Entities\Investigator;
use Doctrine\ORM\EntityRepository;

class InvestigatorRepository extends EntityRepository
{
  /**
   * Summary of getAllInvestigators
   * @return Investigator[]
   */
  public function findAllInvestigators(): array
  {
    return $this->findAll();
  }

  public function findInvestigatorById(string $id): Investigator | null
  {
    return $this->findOneBy(['id' => $id]);
  }

  /**
   * Summary of getInvestigatorByLocations
   * @param array $cities
   * @return Investigator[]|null
   */
  public function findInvestigatorByLocations(array $cities): array | null
  {
    return $this->find(['city' => $cities]);
  }
}