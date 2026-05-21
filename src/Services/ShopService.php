<?php

namespace App\Services;

use App\DTO\SaveShopDTO;
use App\DTO\ShopDTO;
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

  private function mapShopToDTO(Shop $shop): ShopDTO
  {
    $shopDTO = new ShopDTO(
      $shop->getId(),
      $shop->getPlaceName(),
      $shop->getPlaceCode(),
      $shop->getAddress(),
      $shop->getPostalCode(),
      $shop->getCity(),
      $shop->getCountry(),
      $shop->getPhone(),
      $shop->getVisitCode(),
      $shop->getVisitName(),
      $shop->getStartDate() ? $shop->getStartDate()->format('c') : null,
      $shop->getEndDate() ? $shop->getEndDate()->format('c') : null,
      $shop->getType(),
      $shop->getCost(),
      $shop->getLat(),
      $shop->getLng(),
      $shop->getCanBeLunchBreak(),
      $shop->getCanBeMorning(),
      $shop->getCanBeAfternoon(),
      $shop->getCreatedAt()->format('c')
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

  }

  public function getAllShops()
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
      throw new Exception('Unable to retrieve shop with this id', 400);
    }

    $shopDTO = $this->mapShopToDTO($shop);

    return $shopDTO;
  }

  public function createShop(SaveShopDTO $dto): ShopDTO
  {

    $shop = new Shop();
    $this->setShopFromDTO($shop, $dto);

    $this->entityManager->persist($shop);
    $this->entityManager->flush();

    $shopDTO = $this->mapShopToDTO($shop);

    return $shopDTO;
  }

  public function deleteStore(string $id): void
  {
    $shop = $this->shopRepository->findShopById($id);

    if (!$shop) {
      throw new Exception("Unable to delete this shop", code: 400);
    }

    $this->entityManager->remove($shop);
    $this->entityManager->flush();

  }

  public function updateShop(string $id, SaveShopDTO $dto): ShopDTO
  {
    $shop = $this->shopRepository->findShopById($id);

    if (!$shop) {
      throw new Exception("Unable to update this shop", code: 400);
    }

    $this->setShopFromDTO($shop, $dto);
    $this->entityManager->flush();

    $shopDTO = $this->mapShopToDTO($shop);

    return $shopDTO;

  }
}
