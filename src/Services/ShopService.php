<?php

namespace App\Services;

use App\DTO\CreateShopDTO;
use App\DTO\ShopDTO;
use Doctrine\ORM\EntityManagerInterface;
use App\Repositories\ShopRepository;
use App\Entities\Shop;
use DateTime;

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

  public function getAllShops()
  {
    $shops =  $this->shopRepository->getAllShops();
    $dtos = [];

    foreach ($shops as $shop){
      $dtos[] = $this->mapShopToDTO($shop);

    }

    return $dtos;
  }

  public function getShopById(string $id): ShopDTO | null
  {
    $shop = $this->shopRepository->getShopById($id);

    if (!$shop){
      return null;
    }

    $shopDTO = $this->mapShopToDTO($shop);

    return $shopDTO;
  }

  public function createShop(CreateShopDTO $createShopDTO): ShopDTO
  {
    $shop = new Shop(...(array) $createShopDTO);
    $this->entityManager->persist($shop);
    $this->entityManager->flush();
    $shopDTO = $this->mapShopToDTO($shop);
    return $shopDTO;
  }
}
