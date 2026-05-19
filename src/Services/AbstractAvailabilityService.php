<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

abstract class AbstractAvailabilityService
{
  protected EntityManagerInterface $entityManager;
  protected ObjectRepository $repository;

  public function __construct(ObjectRepository $repo, EntityManagerInterface $em)
  {
    $this->repository = $repo;
    $this->entityManager = $em;
  }
}