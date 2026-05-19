<?php

namespace App\Services;

use App\Repositories\ShopAvailabilityRepository;
use Doctrine\ORM\EntityManagerInterface;

class ShopAvailabilityService
{
  private ShopAvailabilityRepository $repository;
  private EntityManagerInterface $entityManager;

  public function __construct(ShopAvailabilityRepository $repo, EntityManagerInterface $em)
  {
    $this->repository = $repo;
    $this->entityManager = $em;
  }
}