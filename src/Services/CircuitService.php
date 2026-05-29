<?php

namespace App\Services;

use App\Entities\Circuit;
use App\Repositories\CircuitRepository;
use Doctrine\ORM\EntityManagerInterface;

class CircuitService
{
  private CircuitRepository $repository;
  private EntityManagerInterface $entityManager;

  public function __construct(CircuitRepository $repo, EntityManagerInterface $em)
  {
    $this->repository = $repo;
    $this->entityManager = $em;
  }


  public function getAllCircuits()
  {
    $circuits = $this->repository->findAll();
    $circuitsDTO = [];

    foreach ($circuits as $circuit) {

    }

    return $circuitsDTO;
  }
}