<?php

require_once __DIR__ . '/bootstrap.php';

use App\Controllers\CircuitController;
use App\Controllers\InvestigatorAvailabilityController;
use App\Controllers\ShopAvailabilityController;
use App\Entities\Circuit;
use App\Entities\Investigator;
use App\Entities\Shop;
use App\Mappers\AvailabilityMapper;
use App\Mappers\CircuitMapper;
use App\Mappers\InvestigatorMapper;
use App\Mappers\ShopMapper;
use App\Mappers\StopMapper;
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


//  MAPPER
$availibilityMapper = new AvailabilityMapper();
$shopMapper = new ShopMapper($availibilityMapper);
$investigatorMapper = new InvestigatorMapper($availibilityMapper);
$stopMapper = new StopMapper();
$circuitMapper = new CircuitMapper($stopMapper);


//  SHOP
$shopRepository = $entityManager->getRepository(Shop::class);
$shopService = new ShopService($shopRepository, $entityManager, $shopMapper);
$shopController = new ShopController($shopService);


//  INVESTIGATOR
$investigatorRepository = $entityManager->getRepository(Investigator::class);
$investigatorService = new InvestigatorService($investigatorRepository, $entityManager, $investigatorMapper);
$investigatorController = new InvestigatorController($investigatorService);


//  SHOP-AVAILABILITY
$shopAvailabilityRepository = $entityManager->getRepository(ShopAvailability::class);
$shopAvailabilityService = new ShopAvailabilityService($shopAvailabilityRepository, $entityManager);
$shopAvailabilityController = new ShopAvailabilityController($shopAvailabilityService);


//  INVESTIGATOR-AVAILABILITY
$investigatorAvaibilityRepository = $entityManager->getRepository(InvestigatorAvailability::class);
$investigatorAvailabilityService = new InvestigatorAvailabilityService($investigatorAvaibilityRepository, $entityManager);
$investigatorAvailabilityController = new InvestigatorAvailabilityController($investigatorAvailabilityService);


//  CIRCUIT²
$circuitRepository = $entityManager->getRepository(Circuit::class);
$circuitService = new CircuitService($circuitRepository, $entityManager, $circuitMapper);
$circuitController = new CircuitController($circuitService);


$router = new AppRouter($shopController, $investigatorController, $circuitController);
$router->run();