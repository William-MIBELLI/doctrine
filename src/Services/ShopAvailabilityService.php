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

      $avail = new ShopAvailability();
      
      $avail->setDayOfWeek($plan->dayOfWeek);
      $avail->setOpenTime(new DateTime($plan->openTime));
      $avail->setCloseTime(new Datetime($plan->closeTime));
      $avail->setShop($shop);

      $this->entityManager->persist($avail);
    }
    $this->entityManager->flush();
  }
}