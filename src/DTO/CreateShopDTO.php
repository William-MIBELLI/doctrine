<?php

namespace App\DTO;

use Webmozart\Assert\Assert;

readonly class CreateShopDTO
{
  
  public function __construct(
    public string $placeName,
    public int $placeCode,
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
    ) {

    Assert::stringNotEmpty($placeName, "Place name must be provided.");
    Assert::integer($placeCode, "Place code must be provided.");
    Assert::stringNotEmpty($address, "Address must be provided");
    Assert::integer($postalCode);
    Assert::stringNotEmpty($city);
    Assert::stringNotEmpty($country);
    Assert::stringNotEmpty($visitCode);
    Assert::stringNotEmpty($visitName);
    Assert::stringNotEmpty($type);
    Assert::float($cost);
    Assert::float($lat);
    Assert::float($lng);
    Assert::boolean($canBeLunchBreak);
    Assert::boolean($canBeMorning);
    Assert::boolean($canBeAfternoon);

    Assert::nullOrString($phone);
    Assert::nullOrString($startDate);
    Assert::nullOrString($endDate);
  }
}
