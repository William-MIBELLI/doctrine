<?php

namespace App\Mappers;

use App\DTO\StopDTO;
use App\Entities\Stop;

class StopMapper
{
  public function toDTO(Stop $stop): StopDTO
  {
    $dto = new StopDTO(
      id: $stop->getId(),
      detourSec: $stop->getDetourSec(),
      label: $stop->getLabel(),
      startTime: $stop->getStartTime()->format('c'),
      createdAt: $stop->getCreatedAt()->format('c'),
      shopId: $stop->getShop()->getId(),
      circuitId: $stop->getCircuit()->getId()
    );

    return $dto;
  }
}