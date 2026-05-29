<?php

namespace App\DTO;

use App\Entities\Stop;

class CircuitDTO
{
  public function __construct(
    public int $id,
    public string $label,
    public string $polyline,
    public string $createdAt,
    public string $startTime,
    public string $endTime,
    public int $travelDurationSec,
    public int $visitDurationSec,
    public int $totalDurationSec,
    public int $travelDistanceMeters,
    public InvestigatorDTO $investigator,

    /** @var Stop[] */
    public array $stops
  ) {}
}