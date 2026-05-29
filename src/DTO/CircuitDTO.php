<?php

namespace App\DTO;


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
    public int $investigatorId,

    /** @var StopDTO[] */
    public array $stops
  ) {}
}