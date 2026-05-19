<?php

namespace App\Services;

use App\DTO\CreateAvailabilityDTO;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

abstract class AbstractAvailabilityService
{
  protected EntityManagerInterface $entityManager;
  protected ObjectRepository $repository;

  public function __construct(ObjectRepository $repo, EntityManagerInterface $em)
  {
    $this->repository = $repo;
    $this->entityManager = $em;
  }

  /**
   * Summary of generateRandomWeekPlanning
   * @return CreateAvailabilityDTO[]
   */
  protected function generateRandomWeekPlanning(): array
  {
    $planning = [];

    for ($i = 1; $i <= 6; $i++) {
      $random = rand(1, 100);

      $openMorning = \sprintf("%02d:00:00", rand(8, 10));
      $closeEvening = \sprintf("%02d:00:00", rand(18, 20));
      $optionsMidi = ["12:00:00", "12:30:00", "13:00:00"];
      $closeMorning = $optionsMidi[array_rand($optionsMidi)];
      $openAfternoon = ["13:30:00", "14:00:00"];

      // ALL DAY LONG
      if ($random <= 15) {
        $planning[] = new CreateAvailabilityDTO(
          dayOfWeek: $i,
          openTime: $openMorning,
          closeTime: $closeEvening
        );

        continue;
      }

      // MORNING & AFTERNOON
      if ($random <= 70) {

        $openAfternoon = \intval(substr($closeMorning, 0, 2)) > 12 ? "14:30:00" : "14:00:00";

        $morning = new CreateAvailabilityDTO(
          dayOfWeek: $i,
          openTime: $openMorning,
          closeTime: $closeMorning
        );
        $afternoon = new CreateAvailabilityDTO(
          dayOfWeek: $i,
          openTime: $openAfternoon,
          closeTime: $closeEvening
        );
        $planning[] = $morning;
        $planning[] = $afternoon;

        continue;
      }

      // ONLY MORNING
      if ($random <= 85) {
        $planning[] = new CreateAvailabilityDTO(
          dayOfWeek: $i,
          openTime: $openMorning,
          closeTime: $closeMorning
        );

        continue;
      }

      // ONLY AFTERNOON
      $planning[] = new CreateAvailabilityDTO(
        dayOfWeek: $i,
        openTime: $openAfternoon[array_rand($openAfternoon)],
        closeTime: $closeEvening
      );
    }
    return $planning;
  }
}
