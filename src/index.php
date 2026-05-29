<?php

require_once __DIR__ . '/bootstrap.php';

use App\Controllers\CircuitController;
use App\Controllers\InvestigatorAvailabilityController;
use App\Controllers\ShopAvailabilityController;
use App\Entities\Circuit;
use App\Entities\Investigator;
use App\Entities\Shop;
use App\Mappers\AvailabilityMapper;
use App\Mappers\InvestigatorMapper;
use App\Mappers\ShopMapper;
use App\Routes\AppRouter;
use App\Services\CircuitService;
use App\Services\InvestigatorAvailabilityService;
use App\Services\InvestigatorService;
use App\Services\ShopAvailabilityService;
use App\Services\ShopService;
use App\Controllers\InvestigatorController;
use App\Controllers\ShopController;
use App\Entities\ShopAvailability;
use App\Entities\InvestigatorAvailability;

$availibilityMapper = new AvailabilityMapper();
$shopMapper = new ShopMapper($availibilityMapper);
$investigatorMapper = new InvestigatorMapper($availibilityMapper);


$shopRepository = $entityManager->getRepository(Shop::class);
$shopService = new ShopService($shopRepository, $entityManager, $shopMapper);
$shopController = new ShopController($shopService);

$investigatorRepository = $entityManager->getRepository(Investigator::class);
$investigatorService = new InvestigatorService($investigatorRepository, $entityManager, $investigatorMapper);
$investigatorController = new InvestigatorController($investigatorService);

$shopAvailabilityRepository = $entityManager->getRepository(ShopAvailability::class);
$shopAvailabilityService = new ShopAvailabilityService($shopAvailabilityRepository, $entityManager);
$shopAvailabilityController = new ShopAvailabilityController($shopAvailabilityService);


$investigatorAvaibilityRepository = $entityManager->getRepository(InvestigatorAvailability::class);
$investigatorAvailabilityService = new InvestigatorAvailabilityService($investigatorAvaibilityRepository, $entityManager);
$investigatorAvailabilityController = new InvestigatorAvailabilityController($investigatorAvailabilityService);

$circuitRepository = $entityManager->getRepository(Circuit::class);
$circuitService = new CircuitService($circuitRepository, $entityManager);
$circuitController = new CircuitController($circuitService);

$router = new AppRouter($shopController, $investigatorController, $circuitController);
$router->run();