<?php

namespace App\DTO;

readonly class InvestigatorDTO
{
  public function __construct(
    public int $id,
    public string $code,
    public string $lastname,
    public string $firstname,
    public string $address,
    public string $postalCode,
    public string $city,
    public string $country,
    public string $phone,
    public float $lat,
    public float $lng,
    public string $createdAt
  ) {}
}