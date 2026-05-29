<?php

namespace App\DTO;

class StopDTO
{
  public function __construct(
    public int $id,
    public int $detourSec,
    public string $label,
    public string $startTime,
    public string $createdAt,
    public int $shopId,
    public int $circuitId
  ) {}
}