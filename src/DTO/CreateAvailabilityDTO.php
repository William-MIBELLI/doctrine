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

  public static function createFromArray(array $data): self
  {
    return new self(
      dayOfWeek: $data['dayOfWeek'],
      openTime: $data['openTime'],
      closeTime: $data['closeTime']
    );
  }
}