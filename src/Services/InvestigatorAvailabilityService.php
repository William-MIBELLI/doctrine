<?php

namespace App\Services;

use App\Repositories\InvestigatorAvailabilityRepository;
use Doctrine\ORM\EntityManagerInterface;

class InvestigatorAvailabilityService extends AbstractAvailabilityService
{

  public function __construct(InvestigatorAvailabilityRepository $repo, EntityManagerInterface $em)
  {
    parent::__construct($repo, $em);
  }
}