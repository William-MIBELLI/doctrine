<?php

namespace App\Services;

use App\Repositories\InvestigatorAvailabilityRepository;
use Doctrine\ORM\EntityManagerInterface;

class InvestigatorAvailabilityService
{
  private InvestigatorAvailabilityRepository $repository;
  private EntityManagerInterface $entityManager;

  public function __construct(InvestigatorAvailabilityRepository $repo, EntityManagerInterface $em)
  {
    $this->repository = $repo;
    $this->entityManager = $em;
  }
}