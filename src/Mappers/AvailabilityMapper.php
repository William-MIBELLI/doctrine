<?php

namespace App\Mappers;

use App\DTO\AvailabilityDTO;
use App\Entities\Interfaces\AvailabilityInterface;


class AvailabilityMapper
{

  public function toDTO(AvailabilityInterface $avail): AvailabilityDTO
  {
    $dto = new AvailabilityDTO(
      id: $avail->getId(),
      dayOfWeek: $avail->getDayOfWeek(),
      openTime: $avail->getOpenTime()->format('H:i'),
      closeTime: $avail->getCloseTime()->format('H:i')
    );
    return $dto;
  }
}