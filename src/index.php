<?php

require_once __DIR__ . '/bootstrap.php';

$shopRepository = $entityManager->getRepository(Shop::class);
$shopService = new ShopService($shopRepository, $entityManager);
$shopController = new ShopController($shopService);