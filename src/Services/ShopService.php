<?php

namespace App\Services;

use App\DTO\SaveShopDTO;
use App\DTO\ShopDTO;
use App\Entities\ShopAvailability;
use App\Mappers\ShopMapper;
use Doctrine\ORM\EntityManagerInterface;
use App\Repositories\ShopRepository;
use App\Entities\Shop;
use DateTime;
use Exception;

class ShopService
{
  private ShopRepository $shopRepository;
  private EntityManagerInterface $entityManager;
  private ShopMapper $mapper;

  public function __construct(ShopRepository $repo, EntityManagerInterface $em, ShopMapper $mapper)
  {
    $this->shopRepository = $repo;
    $this->entityManager = $em;
    $this->mapper = $mapper;
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
      $dtos[] = $this->mapper->toDTO($shop);

    }

    return $dtos;
  }

  public function getShopDetails(string $id): ShopDTO|null
  {
    $shop = $this->shopRepository->findShopById($id);

    if (!$shop) {
      throw new Exception('Unable to retrieve shop with this id', 404);
    }

    $shopDTO = $this->mapper->toDTO($shop, true);

    return $shopDTO;
  }

  public function createShop(SaveShopDTO $dto): ShopDTO
  {

    $shop = new Shop();
    $this->setShopFromDTO($shop, $dto);

    $this->entityManager->persist($shop);
    $this->entityManager->flush();

    $shopDTO = $this->mapper->toDTO($shop, true);

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

    $shopDTO = $this->mapper->toDTO($shop);

    return $shopDTO;

  }
}
