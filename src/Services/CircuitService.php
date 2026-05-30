<?php

namespace App\Services;

use App\DTO\CircuitDTO;
use App\Entities\Circuit;
use App\Mappers\CircuitMapper;
use App\Repositories\CircuitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

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
  public function getCircuits( ?int $investigatorId): array
  {
    $circuits = $this->repository->findCircuitsWithFilters($investigatorId);
    $circuitsDTO = [];

    foreach ($circuits as $circuit) {
      $circuitsDTO[] = $this->mapper->toDTO($circuit);
    }

    return $circuitsDTO;
  }

  public function getCircuitDetails(int $id): CircuitDTO
  {
    $circuit = $this->repository->findCircuitById($id);

    if (!$circuit){
      throw new Exception('No circuit with this id', code: 404);
    }

    $dto = $this->mapper->toDTO($circuit, withStops:true);
    return $dto;
  }

  public function deleteCircuit(int $id): void
  {
    $circuit = $this->repository->findCircuitById($id);

    if (!$circuit) {
      throw new Exception('Unable to delete this circuit', 404);
    }

    $this->entityManager->remove($circuit);
    $this->entityManager->flush();
  }
}