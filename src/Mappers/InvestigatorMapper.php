<?php

namespace App\Mappers;

use App\DTO\InvestigatorDTO;
use App\Entities\Investigator;
use App\DTO\AvailabilityDTO;

class InvestigatorMapper
{

  private AvailabilityMapper $availabilityMapper;

  public function __construct(AvailabilityMapper $availMapper)
  {
    $this->availabilityMapper = $availMapper;
  }

  public function toDTO(Investigator $inv, bool $withAvailabilities = false): InvestigatorDTO
  {

    $availabilitiesDTO = [];

    if ($withAvailabilities) {
      foreach ($inv->getAvailabilities() as $avail) {
        $availabilitiesDTO[] = $this->availabilityMapper->toDTO($avail);
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
      phone: $inv->getPhone(),
      lat: $inv->getLat(),
      lng: $inv->getLng(),
      createdAt: $inv->getCreatedAt()->format("c"),
      availabilities: $availabilitiesDTO
    );

    return $dto;
  }
}