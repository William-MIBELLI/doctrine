<?php

require_once __DIR__ . '/bootstrap.php';

use App\Entities\Investigator;
use App\Entities\Shop;
use App\Routes\Router;
use App\Services\InvestigatorService;
use App\Services\ShopService;
use App\Controllers\InvestigatorController;
use App\Controllers\ShopController;

$shopRepository = $entityManager->getRepository(Shop::class);
$shopService = new ShopService($shopRepository, $entityManager);
$shopController = new ShopController($shopService);

$investigatorRepository = $entityManager->getRepository(Investigator::class);
$investigatorService = new InvestigatorService($investigatorRepository, $entityManager);
$investigatorController = new InvestigatorController($investigatorService);

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