<?php

namespace App\Mappers;

use App\Entities\ShopAvailability;
use App\DTO\SaveShopDTO;
use App\DTO\ShopDTO;
use App\Entities\Shop;
use DateTime;

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

  public function fromDTO(Shop $shop, SaveShopDTO $dto): void
  {
    $shop->setPlaceCode($dto->placeCode);
    $shop->setPlaceName($dto->placeName);
    $shop->setAddress($dto->address);
    $shop->setPostalCode($dto->postalCode);
    $shop->setCity($dto->city);
    $shop->setCountry($dto->country);
    $shop->setPhone($dto->phone ?? null);
    $shop->setVisitCode($dto->visitCode);
    $shop->setVisitName($dto->visitName);
    $shop->setStartDate($dto->startDate ? new DateTime($dto->startDate) : null);
    $shop->setEndDate($dto->endDate ? new DateTime($dto->endDate) : null);
    $shop->setType($dto->type);
    $shop->setCost($dto->cost);
    $shop->setLat($dto->lat);
    $shop->setLng($dto->lng);
    $shop->setCanBeLunchBreak($dto->canBeLunchBreak ?? false);
    $shop->setCanBeMorning($dto->canBeMorning ?? false);
    $shop->setCanBeAfternoon($dto->canBeAfternoon ?? false);
    $shop->getAvailabilities()->clear();

    foreach ($dto->availabilitiesDTO as $availDTO) {

      $avail = new ShopAvailability();
      $this->availabilityMapper->fromDTO($avail, $availDTO);
      $avail->setShop($shop);

      $shop->addAvailability($avail);
    }
  }
}