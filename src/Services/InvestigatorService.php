<?php

namespace App\Services;

use App\DTO\AvailabilityDTO;
use App\DTO\InvestigatorDTO;
use Doctrine\ORM\EntityManagerInterface;
use App\Repositories\InvestigatorRepository;
use App\Entities\Investigator;
use Exception;

class InvestigatorService
{

  private InvestigatorRepository $investigatorRepository;
  private EntityManagerInterface $entityManager;

  public function __construct(InvestigatorRepository $repo, EntityManagerInterface $em)
  {
    $this->investigatorRepository = $repo;
    $this->entityManager = $em;
  }

  private function mapInvestigatorToDTO(Investigator $inv, bool $withAvailabilities = false): InvestigatorDTO
  {

    $availabilitiesDTO = [];

    if ($withAvailabilities){
      foreach ($inv->getAvailabilities() as $avail) {
        $availabilitiesDTO[] = new AvailabilityDTO(
          id: $avail->getId(),
          dayOfWeek: $avail->getDayOfWeek(),
          openTime: $avail->getOpenTime()->format('H:i'),
          closeTime: $avail->getCloseTime()->format('H:i')
        );
      }
    }

    $dto = new InvestigatorDTO(
      id: $inv->getId(),
      code: $inv->getCode(),
      lastname: $inv->getLastname(),
      firstname: $inv->getFirstname(),
      address: $inv->getAddress(),
      postalCode: $inv->getPostalCode(),
      city: $inv->getCity(),
      country: $inv->getCountry(),
      phone:$inv->getPhone(),
      lat: $inv->getLat(),
      lng: $inv->getLng(),
      createdAt: $inv->getCreatedAt()->format("c"),
      availabilities: $availabilitiesDTO
    );

    return $dto;
  }

  /**
   * Summary of getAllInvestigators
   * @return InvestigatorDTO[]
   */
  public function getAllInvestigators(): array
  {
    $investigators = $this->investigatorRepository->getAllInvestigators();
    $dtos = [];

    foreach ($investigators as $inv) {
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

  public function getInvestigatorDetails(string $id): InvestigatorDTO
  {
    $investigator = $this->investigatorRepository->findInvestigatorById($id);

    if (!$investigator) {
      throw new Exception("Unable to retrieve investigator with this id", 404);
    }

    $dto = $this->mapInvestigatorToDTO($investigator, true);

    return $dto;
  }

}
