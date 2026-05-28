<?php

namespace App\Database;

use App\Services\InvestigatorService;
use App\Services\ShopService;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;

use App\Entities\Shop;
use App\Entities\Investigator;
use App\Repositories\InvestigatorRepository;
use App\Repositories\ShopRepository;
use App\Services\InvestigatorAvailabilityService;
use App\Services\ShopAvailabilityService;

class DatabaseSeeder
{
  public function __construct(
    private EntityManagerInterface $entityManager,
    private ShopService $shopService,
    private ShopRepository $shopRepo,
    private InvestigatorService $investigatorService,
    private InvestigatorRepository $investigatorRepo,
    private ShopAvailabilityService $shopAvailabilityService,
    private InvestigatorAvailabilityService $investigatorAvailabilityService,
  ) {
  }

  public function run(): void
  {
    $this->seedShopFromCSV();
    $shops = $this->shopRepo->getAllShops();

    foreach ($shops as $shop) {
      $this->shopAvailabilityService->generateAndSaveRandomPlanning($shop);
    }

    $this->seedInvestigatorFromCSV();
    $investigators = $this->investigatorRepo->getAllInvestigators();

    foreach ($investigators as $investigator) {
      $this->investigatorAvailabilityService->generateAndSaveRandomPlanning($investigator);
    }
  }

  private function seedShopFromCSV()
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
        if (\count($headers) === \count($rowData)) {
          $csvData[] = array_combine($headers, $rowData);
        }
      }
      fclose($handler);
    }

    try {
      foreach ($csvData as $row) {

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

        $shop = new Shop();
        $shop->setPlaceCode($row['placeCode']);
        $shop->setPlaceName($row['placeName']);
        $shop->setAddress($row['address']);
        $shop->setPostalCode($row['postalCode']);
        $shop->setCity($row['city']);
        $shop->setCountry($row['country']);
        $shop->setPhone($row['phone'] ?? null);
        $shop->setVisitCode($row['visitCode']);
        $shop->setVisitName($row['visitName']);
        $shop->setStartDate($row['startDate']);
        $shop->setEndDate($row['endDate']);
        $shop->setType($row['type']);
        $shop->setCost($row['cost']);
        $shop->setLat($row['lat']);
        $shop->setLng($row['lng']);

        $shop->setCanBeLunchBreak($row['canBeLunchBreak'] ?? false);
        $shop->setCanBeMorning($row['canBeMorning'] ?? false);
        $shop->setCanBeAfternoon($row['canBeAfternoon'] ?? false);

        $this->entityManager->persist($shop);
        $i++;

        if ($i % $bacthSize === 0) {
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

  private function seedInvestigatorFromCSV()
  {
    $keys = [
      'id',
      'code',
      'firstname',
      'lastname',
      'address',
      'postalCode',
      'city',
      'country',
      'phone',
      'lat',
      'lng'
    ];

    $datas = [];
    $batchSize = 200;
    $i = 0;

    if (($handler = fopen(__DIR__ . "/../data/investigators.csv", "r")) !== false) {
      $skipped = fgetcsv($handler, null, ";", "\"", "\\");

      while (($row = fgetcsv($handler, null, ";", "\"", "\\")) !== false) {
        $datas[] = array_combine($keys, $row);
      }
      fclose($handler);
    }

    try {
      foreach ($datas as $data) {
        $data['postalCode'] = (int) $data['postalCode'];
        $data['lat'] = (float) $data['lat'];
        $data['lng'] = (float) $data['lng'];

        unset($data['id']);

        $investigator = new Investigator();
        
        $investigator->setCode($data['code']);
        $investigator->setFirstname($data['firstname']);
        $investigator->setLastname($data['lastname']);
        $investigator->setAddress($data['address']);
        $investigator->setPostalCode($data['postalCode']);
        $investigator->setCity($data['city']);
        $investigator->setCountry($data['country']);
        $investigator->setPhone($data['phone']);
        $investigator->setLat($data['lat']);
        $investigator->setLng($data['lng']);

        $this->entityManager->persist($investigator);
        $i++;

        if ($i % $batchSize === 0) {
          $this->entityManager->flush();
          $this->entityManager->clear();
        }
      }

      $this->entityManager->flush();
      $this->entityManager->clear();

      return true;
    } catch (\Throwable $th) {
      error_log("Something goes wrong while seeding investigator : {$th->getMessage()}");
      return false;
    }
  }


}