<?php

require_once __DIR__ . '/bootstrap.php';

use App\Controllers\InvestigatorAvailabilityController;
use App\Controllers\ShopAvailabilityController;
use App\Entities\Investigator;
use App\Entities\Shop;
use App\Routes\Router;
use App\Services\InvestigatorAvailabilityService;
use App\Services\InvestigatorService;
use App\Services\ShopAvailabilityService;
use App\Services\ShopService;
use App\Controllers\InvestigatorController;
use App\Controllers\ShopController;
use App\Entities\ShopAvailability;
use App\Entities\InvestigatorAvailability;


$shopRepository = $entityManager->getRepository(Shop::class);
$shopService = new ShopService($shopRepository, $entityManager);
$shopController = new ShopController($shopService);

$investigatorRepository = $entityManager->getRepository(Investigator::class);
$investigatorService = new InvestigatorService($investigatorRepository, $entityManager);
$investigatorController = new InvestigatorController($investigatorService);

$shopAvailabilityRepository = $entityManager->getRepository(ShopAvailability::class);
$shopAvailabilityService = new ShopAvailabilityService($shopAvailabilityRepository, $entityManager);
$shopAvailabilityController = new ShopAvailabilityController($shopAvailabilityService);


$investigatorAvaibilityRepository = $entityManager->getRepository(InvestigatorAvailability::class);
$investigatorAvailabilityService = new InvestigatorAvailabilityService($investigatorAvaibilityRepository, $entityManager);
$investigatorAvailabilityController = new InvestigatorAvailabilityController($investigatorAvailabilityService);


$router = new Router();

$router->addRoute("GET", '/shops', $shopController, 'list');
$router->addRoute("POST", '/shops', $investigatorController, 'create');
$router->addRoute("DELETE", '/shops/id', $investigatorController, 'delete');
$router->addRoute("GET", '/shops/seed', $investigatorController, 'seed');


$router->addRoute("GET", '/investigators', $investigatorController, 'list');
$router->addRoute("POST", '/investigators', $investigatorController, 'create');
$router->addRoute("DELETE", '/investigators/id', $investigatorController, 'delete');
$router->addRoute("GET", '/investigators/seed', $investigatorController, 'seed');


$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
// $investigatorService->seedFromCSV();
// $shopService->seedFromCSV();