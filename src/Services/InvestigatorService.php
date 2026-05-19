<?php

namespace App\Services;

use App\DTO\InvestigatorDTO;
use Doctrine\ORM\EntityManagerInterface;
use App\Repositories\InvestigatorRepository;
use App\Entities\Investigator;

class InvestigatorService
{

  private InvestigatorRepository $repository;
  private EntityManagerInterface $entityManager;

  public function __construct(InvestigatorRepository $repo, EntityManagerInterface $em)
  {
    $this->repository = $repo;
    $this->entityManager = $em;
  }

  /**
   * Summary of getAllInvestigators
   * @return InvestigatorDTO[]
   */
  public function getAllInvestigators(): array
  {
    $investigators =  $this->repository->getAllInvestigators();
    $dtos = [];

    foreach ($investigators as $inv){
      $dtos[] = new InvestigatorDTO(
        $inv->getId(),
        $inv->getCode(),
        $inv->getLastname(),
        $inv->getFirstname(),
        $inv->getAddress(),
        $inv->getPostalCode(),
        $inv->getCity(),
        $inv->getCountry(),
        $inv->getPhone(),
        $inv->getLat(),
        $inv->getLng(),
        $inv->getCreatedAt()->format("c")
      );
    }

    return $dtos;
  }

}
