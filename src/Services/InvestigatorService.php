<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use App\Repositories\InvestigatorRepository;
use App\Entities\Investigator;

class InvestigatorService
{

  private InvestigatorRepository $repository;
  private EntityManagerInterface $entityManager;

  public function __construct(InvestigatorRepository $repo, EntityManagerInterface $em)
  {
    $this->repository = $repo;
    $this->entityManager = $em;
  }

  public function getAllInvestigators()
  {
    return $this->repository->getAllInvestigators();
  }

  public function seedFromCSV()
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

        $investigator = new Investigator(...$data);
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
