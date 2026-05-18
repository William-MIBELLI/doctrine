<?php

use Doctrine\ORM\EntityRepository;

class InvestigatorRepository extends EntityRepository
{
  public function getAllInvestigators()
  {
    return $this->findAll();
  }

  public function getInvestigatorById(string $id)
  {
    return $this->findOneBy(['id' => $id]);
  }

  public function getInvestigatorByLocations(array $cities)
  {
    return $this->find(['city' => $cities]);
  }
}