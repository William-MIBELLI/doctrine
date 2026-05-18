<?php

namespace App\DTO;

readonly class AvailabilityDTO
{
  public function __construct(
    public int $id,
    public int $dayOfWeek,
    public string $openTime,
    public string $closeTime
  ) {}
}