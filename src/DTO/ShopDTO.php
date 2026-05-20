<?php

namespace App\DTO;

readonly class ShopDTO
{
    public function __construct(
        public ?int $id,
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
        public string $createdAt
    ) {}
}