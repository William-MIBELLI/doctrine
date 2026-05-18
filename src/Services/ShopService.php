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

  public function seedFromCSV(): bool
  {
    $bacthSize = 200;
    $i = 0;
    $csvData = [];
    $headers = [
      'placeCode',
      'placeName',
      'address',
      'postalCode',
      'city',
      'country',
      'phone',
      'visitCode',
      'visitName',
      'startDate',
      'endDate',
      'comments',
      'type',
      'lng',
      'lat',
    ];

    if (($handler = fopen(__DIR__ . '/../data/visits_proxi.csv', 'r')) !== false) {

      $skipped = fgetcsv($handler, null, ";", "\"", "\\");

      while (($rowData = fgetcsv($handler, null, ';', "\"", "\\")) !== false) {
        if (count($headers) === count($rowData)) {
          $csvData[] = array_combine($headers, $rowData);
        }
      }
      fclose($handler);
    }

    try {
      foreach ($csvData as $row) {

        $row['placeCode'] = (int) $row['placeCode'];
        $row['postalCode'] = (int) $row['postalCode'];
        $row['phone'] = (int) $row['phone'];
        $row['lng'] = (float) $row['lng'];
        $row['lat'] = (float) $row['lat'];
        $row['cost'] = (int) 30;

        $row['startDate'] = empty($row['startDate']) ? null : new DateTime($row['startDate']);
        $row['endDate'] = empty($row['endDate']) ? null : new DateTime($row['endDate']);

        switch ($row['comments']) {
          case "Visite à faire l'après-midi":
            $row['canBeAfternoon'] = true;
            break;
          case "Période libre - pas entre 12h et 14h":
            $row['canBeAfternoon'] = true;
            $row['canBeMorning'] = true;
            break;
          case "Visite à faire le matin":
            $row['canBeMorning'] = true;
            break;
          default:
            $row['canBeAfternoon'] = true;
            $row['canBeMorning'] = true;
            $row['canBeLunchBreak'] = true;
        }

        unset($row['comments']);

        $shop = new Shop(...$row);
        $this->entityManager->persist($shop);
        $i++;

        if ($i % $bacthSize === 0){
          $this->entityManager->flush();
          $this->entityManager->clear();
        }
      }

      $this->entityManager->flush();
      $this->entityManager->clear();

      return true;
    } catch (\Throwable $th) {
      error_log("Something goes wrong while seeding Shop : {$th->getMessage()}");
      return false;
    }
  }
}
