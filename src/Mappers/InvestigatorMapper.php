<?php

namespace App\Mappers;

use App\DTO\InvestigatorDTO;
use App\DTO\SaveInvestigatorDTO;
use App\Entities\Investigator;
use App\DTO\AvailabilityDTO;
use App\Entities\InvestigatorAvailability;
use DateTime;

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

  public function fromDTO(Investigator $inv, SaveInvestigatorDTO $dto): void
  {
    $inv->setCode($dto->code);
    $inv->setLastname($dto->lastname);
    $inv->setFirstname($dto->firstname);
    $inv->setAddress($dto->address);
    $inv->setPostalCode($dto->postalCode);
    $inv->setCity($dto->city);
    $inv->setCountry($dto->country);
    $inv->setPhone($dto->phone);
    $inv->setLat($dto->lat);
    $inv->setLng($dto->lng);

    $inv->getAvailabilities()->clear();

    foreach ($dto->availabilities as $availDTO) {
      
      $avail = new InvestigatorAvailability();
      $this->availabilityMapper->fromDTO($avail, $availDTO);
      $avail->setInvestigator($inv);

      $inv->addAvailability($avail);
    }
  }
}