<?php

namespace App\Services;

use App\DTO\ShopDTO;
use Doctrine\ORM\EntityManagerInterface;
use App\Repositories\ShopRepository;
use DateTime;
use App\Entities\Shop;

class ShopService
{
  private ShopRepository $shopRepository;
  private EntityManagerInterface $entityManager;

  public function __construct(ShopRepository $repo, EntityManagerInterface $em)
  {
    $this->shopRepository = $repo;
    $this->entityManager = $em;
  }

  public function getAllShops()
  {
    $shops =  $this->shopRepository->getAllShops();
    $dtos = [];

    foreach ($shops as $shop){
      $dtos[] = new ShopDTO(
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

    }

    return $dtos;
  }

}
