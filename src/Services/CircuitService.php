<?php

namespace App\Services;

use App\DTO\CircuitDTO;
use App\Entities\Circuit;
use App\Mappers\CircuitMapper;
use App\Repositories\CircuitRepository;
use Doctrine\ORM\EntityManagerInterface;

class CircuitService
{
  private CircuitRepository $repository;
  private EntityManagerInterface $entityManager;
  private CircuitMapper $mapper;

  public function __construct(CircuitRepository $repo, EntityManagerInterface $em, CircuitMapper $mapper)
  {
    $this->repository = $repo;
    $this->entityManager = $em;
    $this->mapper = $mapper;
  }


  /**
   * Summary of getAllCircuits
   * @return CircuitDTO[]
   */
  public function getAllCircuits(): array
  {
    $circuits = $this->repository->findAllCircuits();
    $circuitsDTO = [];

    foreach ($circuits as $circuit) {

    }

    return $circuitsDTO;
  }
}