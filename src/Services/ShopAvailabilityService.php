<?php

namespace App\Services;

use App\Repositories\ShopAvailabilityRepository;
use Doctrine\ORM\EntityManagerInterface;

class ShopAvailabilityService extends AbstractAvailabilityService
{

  public function __construct(ShopAvailabilityRepository $repo, EntityManagerInterface $em)
  {
    parent::__construct($repo, $em);
  }
}