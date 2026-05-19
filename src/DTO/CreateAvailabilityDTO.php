<?php

namespace App\DTO;

readonly class CreateAvailabilityDTO
{
  public function __construct(
    public int $dayOfWeek,
    public string $openTime,
    public string $closeTime
  )
  {}
}