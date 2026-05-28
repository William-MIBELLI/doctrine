<?php

namespace App\DTO;

readonly class SaveShopDTO
{

  public function __construct(
    public string $placeName,
    public string $placeCode,
    public string $address,
    public int $postalCode,
    public string $city,
    public string $country,
    public ?string $phone,
    public string $visitCode,
    public string $visitName,
    public ?string $startDate,
    public ?string $endDate,
    public string $type,
    public float $cost,
    public float $lat,
    public float $lng,
    public bool $canBeLunchBreak,
    public bool $canBeMorning,
    public bool $canBeAfternoon,

    /** @var CreateAvailabilityDTO[] */
    public array $availabilitiesDTO = [],
  ) {
  }

  public static function createFromArray(array $data): self
  {
    $availabilitiesDTO = [];

    foreach ($data['availabilities'] as $avail) {
      $availabilitiesDTO[] = CreateAvailabilityDTO::createFromArray($avail);
    }

    $dto = new self(
      placeName: $data['placeName'],
      placeCode: $data['placeCode'],
      address: $data['address'],
      postalCode: (int) $data['postalCode'],
      city: $data['city'],
      country: $data['country'],
      phone: $data['phone'] ?? null,
      visitCode: $data['visitCode'],
      visitName: $data['visitName'],
      startDate: $data['startDate'] ?? null,
      endDate: $data['endDate'] ?? null,
      type: $data['type'],
      cost: (float) $data['cost'],
      lat: (float) $data['lat'],
      lng: (float) $data['lng'],
      canBeLunchBreak: (bool) ($data['canBeLunchBreak'] ?? false),
      canBeMorning: (bool) ($data['canBeMorning'] ?? false),
      canBeAfternoon: (bool) ($data['canBeAfternoon'] ?? false),
      availabilitiesDTO: $availabilitiesDTO
    );




    return $dto;
  }
}
