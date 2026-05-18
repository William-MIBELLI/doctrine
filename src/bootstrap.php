<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once __DIR__ . "/../vendor/autoload.php";

$config = ORMSetup::createAttributeMetadataConfig(
  paths: [__DIR__ . '/class'],
  isDevMode: true
);

$config->enableNativeLazyObjects(true);

$connection = DriverManager::getConnection([
  'driver' => 'pdo_pgsql',
  'host' => 'db',
  'dbname' => 'ma_base',
  'user' => 'user',
  'password' => 'password'
], $config);

$entityManager = new EntityManager($connection, $config);