<?php

require_once __DIR__ . '/bootstrap.php';

use App\Entities\Investigator;
use App\Entities\Shop;
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

$investigatorService->seedFromCSV();
$shopService->seedFromCSV();