<?php

if (php_sapi_name() !== 'cli'){
  die("Impossible to seed DB from browser.");
}

require_once __DIR__ . '/../src/bootstrap.php';


use App\Database\DatabaseSeeder;
use App\Entities\Investigator;
use App\Entities\Shop;
use App\Entities\ShopAvailability;
use App\Entities\InvestigatorAvailability;
use App\Services\InvestigatorService;
use App\Services\ShopService;
use App\Services\ShopAvailabilityService;
use App\Services\InvestigatorAvailabilityService;

error_log("-------- Seeder init ---------- \n");

$shopRepository = $entityManager->getRepository(Shop::class);
$shopService = new ShopService($shopRepository, $entityManager);

$investigatorRepository = $entityManager->getRepository(Investigator::class);
$investigatorService = new InvestigatorService($investigatorRepository, $entityManager);

$shopAvailabilityRepository = $entityManager->getRepository(ShopAvailability::class);
$shopAvailabilityService = new ShopAvailabilityService($shopAvailabilityRepository, $entityManager);

$investAvailabilityRepository = $entityManager->getRepository(InvestigatorAvailability::class);
$investAvailabilityService = new InvestigatorAvailabilityService($investAvailabilityRepository, $entityManager);

$databaseSeeder = new DatabaseSeeder(
    $entityManager,
    $shopService,
    $shopRepository,
    $investigatorService,
    $investigatorRepository,
    $shopAvailabilityService,
    $investAvailabilityService
);

error_log("-------- Seeding in progress ---------- \n");
$databaseSeeder->run();
error_log("-------- Successfully seeded -------- \n");