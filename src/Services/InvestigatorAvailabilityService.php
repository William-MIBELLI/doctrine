<?php

namespace App\Services;

use App\Entities\Investigator;
use App\Entities\InvestigatorAvailability;
use App\Repositories\InvestigatorAvailabilityRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class InvestigatorAvailabilityService extends AbstractAvailabilityService
{

  public function __construct(InvestigatorAvailabilityRepository $repo, EntityManagerInterface $em)
  {
    parent::__construct($repo, $em);
  }

  public function generateAndSaveRandomPlanning(Investigator $investigator): void
  {
    $planning = $this->generateRandomWeekPlanning();

    foreach ($planning as $plan) {
      $avail = new InvestigatorAvailability(
        dayOfWeek: $plan->dayOfWeek,
        openTime: new DateTime($plan->openTime),
        closeTime: new DateTime($plan->closeTime)
      );
      $avail->setInvestigator($investigator);

      $this->entityManager->persist($avail);
    }

    $this->entityManager->flush();
  }
}