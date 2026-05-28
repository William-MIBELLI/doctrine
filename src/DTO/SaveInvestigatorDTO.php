<?php

namespace App\DTO;

class SaveInvestigatorDTO
{
  public function __construct(
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

    /** @var CreateAvailabilityDTO[] */
    public array $availabilities = []
  ) {}

  public static function createFromArray(array $data): self
  {

    $availabilitiesDTO = [];
    
    if (isset($data['availabilities']) && \is_array($data['availabilities'])) {
      foreach ($data['availabilities'] as $avail) {
        $availabilitiesDTO[] = CreateAvailabilityDTO::createFromArray($avail);
      }
    }

    return new self(
      code: $data['code'] ?? '',
      lastname: $data['lastname'] ?? '',
      firstname: $data['firstname'] ?? '',
      address: $data['address'] ?? '',
      postalCode: $data['postalCode'] ?? '',
      city: $data['city'] ?? '',
      country: $data['country'] ?? '',
      phone: $data['phone'] ?? '',
      lat: (float)($data['lat'] ?? 0),
      lng: (float)($data['lng'] ?? 0),
      availabilities: $availabilitiesDTO
    );
  }
}