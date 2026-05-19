<?php

namespace App\Services;

use App\Entities\Shop;
use App\Entities\ShopAvailability;
use App\Repositories\ShopAvailabilityRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class ShopAvailabilityService extends AbstractAvailabilityService
{

  public function __construct(ShopAvailabilityRepository $repo, EntityManagerInterface $em)
  {
    parent::__construct($repo, $em);
  }

  public function generateAndSaveRandomPlanning(Shop $shop)
  {
    $planning = $this->generateRandomWeekPlanning();

    foreach ($planning as $plan) {
      $avail = new ShopAvailability(
        dayOfWeek: $plan->dayOfWeek,
        openTime: new DateTime($plan->openTime),
        closeTime: new DateTime($plan->closeTime)
      );
      $avail->setShop($shop);

      $this->entityManager->persist($avail);
    }
    $this->entityManager->flush();
  }
}