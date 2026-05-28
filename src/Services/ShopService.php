<?php

namespace App\Services;

use App\DTO\AvailabilityDTO;
use App\DTO\SaveShopDTO;
use App\DTO\ShopDTO;
use App\Entities\ShopAvailability;
use Doctrine\ORM\EntityManagerInterface;
use App\Repositories\ShopRepository;
use App\Entities\Shop;
use DateTime;
use Exception;

class ShopService
{
  private ShopRepository $shopRepository;
  private EntityManagerInterface $entityManager;

  public function __construct(ShopRepository $repo, EntityManagerInterface $em)
  {
    $this->shopRepository = $repo;
    $this->entityManager = $em;
  }

  private function mapShopToDTO(Shop $shop, bool $withAvailabilities = false): ShopDTO
  {
    $availabilitiesDTO = [];
    if ($withAvailabilities) {
      foreach ($shop->getAvailabilities() as $avail) {
        $availabilitiesDTO[] = new AvailabilityDTO(
          id: $avail->getId(),
          dayOfWeek: $avail->getDayOfWeek(),
          openTime: $avail->getOpenTime()->format('H:i'),
          closeTime: $avail->getCloseTime()->format('H:i')
        );
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

  private function setShopFromDTO(Shop $shop, SaveShopDTO $dto): void
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

      $avail->setShop($shop);
      $avail->setDayOfWeek($availDTO->dayOfWeek);
      $avail->setOpenTime(new DateTime($availDTO->openTime));
      $avail->setCloseTime(new DateTime($availDTO->closeTime));

      $shop->addAvaibality($avail);
    }

  }

  /**
   * Summary of getAllShops
   * @return ShopDTO[]
   */
  public function getAllShops(): array
  {
    $shops = $this->shopRepository->findAllShops();
    $dtos = [];

    foreach ($shops as $shop) {
      $dtos[] = $this->mapShopToDTO($shop);

    }

    return $dtos;
  }

  public function getShopDetails(string $id): ShopDTO|null
  {
    $shop = $this->shopRepository->findShopById($id);

    if (!$shop) {
      throw new Exception('Unable to retrieve shop with this id', 404);
    }

    $shopDTO = $this->mapShopToDTO($shop, true);

    return $shopDTO;
  }

  public function createShop(SaveShopDTO $dto): ShopDTO
  {

    $shop = new Shop();
    $this->setShopFromDTO($shop, $dto);

    $this->entityManager->persist($shop);
    $this->entityManager->flush();

    $shopDTO = $this->mapShopToDTO($shop, true);

    return $shopDTO;
  }

  public function deleteStore(string $id): void
  {
    $shop = $this->shopRepository->findShopById($id);

    if (!$shop) {
      throw new Exception("Unable to delete this shop", code: 404);
    }

    $this->entityManager->remove($shop);
    $this->entityManager->flush();

  }

  public function updateShop(string $id, SaveShopDTO $dto): ShopDTO
  {
    $shop = $this->shopRepository->findShopById($id);

    if (!$shop) {
      throw new Exception("Unable to update this shop", code: 404);
    }

    $this->setShopFromDTO($shop, $dto);
    $this->entityManager->flush();

    $shopDTO = $this->mapShopToDTO($shop);

    return $shopDTO;

  }
}
