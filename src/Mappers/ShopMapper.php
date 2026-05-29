<?php

namespace App\Mappers;

use App\DTO\ShopDTO;
use App\Entities\Shop;

class ShopMapper
{

  private AvailabilityMapper $availabilityMapper;

  public function __construct(AvailabilityMapper $availMapper)
  {
    $this->availabilityMapper = $availMapper;
  }

  public function toDTO(Shop $shop, bool $withAvailabilities = false): ShopDTO
  {
    $availabilitiesDTO = [];
    if ($withAvailabilities) {
      foreach ($shop->getAvailabilities() as $avail) {
        $availabilitiesDTO[] = $this->availabilityMapper->toDTO($avail);
      }
    }

    $shopDTO = new ShopDTO(
      id: $shop->getId(),
      placeName: $shop->getPlaceName(),
      placeCode: $shop->getPlaceCode(),
      address: $shop->getAddress(),
      postalCode: $shop->getPostalCode(),
      city: $shop->getCity(),
      country: $shop->getCountry(),
      phone: $shop->getPhone(),
      visitCode: $shop->getVisitCode(),
      visitName: $shop->getVisitName(),
      startDate: $shop->getStartDate() ? $shop->getStartDate()->format('c') : null,
      endDate: $shop->getEndDate() ? $shop->getEndDate()->format('c') : null,
      type: $shop->getType(),
      cost: $shop->getCost(),
      lat: $shop->getLat(),
      lng: $shop->getLng(),
      canBeLunchBreak: $shop->getCanBeLunchBreak(),
      canBeMorning: $shop->getCanBeMorning(),
      canBeAfternoon: $shop->getCanBeAfternoon(),
      createdAt: $shop->getCreatedAt()->format('c'),
      availabilities: $availabilitiesDTO
    );

    return $shopDTO;
  }
}