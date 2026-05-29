<?php

namespace App\Mappers;

use App\DTO\CircuitDTO;
use App\Entities\Circuit;

class CircuitMapper
{
  private StopMapper $stopMapper;

  public function __construct(StopMapper $stopMapper)
  {
    $this->stopMapper = $stopMapper;
  }

  public function toDTO(Circuit $circuit, bool $withStops = false): CircuitDTO
  {

    $stopsDTO = [];

    if ($withStops) {
      foreach ($circuit->getStops() as $stop){
        $stopsDTO[] = $this->stopMapper->toDTO($stop);
      }
    }

    $dto = new CircuitDTO(
      id: $circuit->getId(),
      label: $circuit->getLabel(),
      polyline: $circuit->getPolyline(),
      createdAt: $circuit->getCreatedAt()->format('c'),
      startTime: $circuit->getStartTime()->format('c'),
      endTime: $circuit->getEndTime()->format('c'),
      travelDurationSec: $circuit->getTravelDurationSec(),
      visitDurationSec: $circuit->getVisitDurationSec(),
      totalDurationSec: $circuit->getTotalDurationSec(),
      travelDistanceMeters: $circuit->getTravelDistanceMeters(),
      stops: $stopsDTO,
      investigatorId: $circuit->getInvestigator()->getId()
    );

    return $dto;
  }

}