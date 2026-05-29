<?php

namespace App\Services;

use App\DTO\AvailabilityDTO;
use App\DTO\InvestigatorDTO;
use App\DTO\SaveInvestigatorDTO;
use App\Entities\InvestigatorAvailability;
use App\Mappers\InvestigatorMapper;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use App\Repositories\InvestigatorRepository;
use App\Entities\Investigator;
use Exception;

class InvestigatorService
{

  private InvestigatorRepository $investigatorRepository;
  private EntityManagerInterface $entityManager;
  private InvestigatorMapper $mapper;

  public function __construct(InvestigatorRepository $repo, EntityManagerInterface $em, InvestigatorMapper $mapper)
  {
    $this->investigatorRepository = $repo;
    $this->entityManager = $em;
    $this->mapper = $mapper;
  }


  private function setInvestigatorFromDTO(Investigator $inv, SaveInvestigatorDTO $dto)
  {
    $inv->setCode($dto->code);
    $inv->setLastname($dto->lastname);
    $inv->setFirstname($dto->firstname);
    $inv->setAddress($dto->address);
    $inv->setPostalCode($dto->postalCode);
    $inv->setCity($dto->city);
    $inv->setCountry($dto->country);
    $inv->setPhone($dto->phone);
    $inv->setLat($dto->lat);
    $inv->setLng($dto->lng);

    $inv->getAvailabilities()->clear();

    foreach ($dto->availabilities as $availDTO) {
      $avail = new InvestigatorAvailability();

      $avail->setDayOfWeek($availDTO->dayOfWeek);
      $avail->setOpenTime(new DateTime($availDTO->openTime));
      $avail->setCloseTime(new DateTime($availDTO->closeTime));
      $avail->setInvestigator($inv);

      $inv->addAvailability($avail);
    }    
  }

  /**
   * Summary of getAllInvestigators
   * @return InvestigatorDTO[]
   */
  public function getAllInvestigators(): array
  {
    $investigators = $this->investigatorRepository->findAllInvestigators();
    $dtos = [];

    foreach ($investigators as $inv) {
      $dtos[] = $this->mapper->toDTO($inv);
    }

    return $dtos;
  }

  public function getInvestigatorDetails(string $id): InvestigatorDTO
  {
    $investigator = $this->investigatorRepository->findInvestigatorById($id);

    if (!$investigator) {
      throw new Exception("Unable to retrieve investigator with this id", 404);
    }

    $dto = $this->mapper->toDTO($investigator, true);

    return $dto;
  }

  public function createInvestigator(SaveInvestigatorDTO $dto): InvestigatorDTO
  {

    $inv = new Investigator();
    $this->setInvestigatorFromDTO($inv, $dto);
    

    $this->entityManager->persist($inv);
    $this->entityManager->flush();

    $investigatorDTO = $this->mapper->toDTO($inv, withAvailabilities:true);

    return $investigatorDTO;
  }

  public function deleteInvestigator(string $id): void
  {
    $inv = $this->investigatorRepository->findInvestigatorById($id);

    if (!$inv) {
      throw new Exception('Unable to delete this investigator', code: 404);
    }

    $this->entityManager->remove($inv);
    $this->entityManager->flush();
  }

  public function updateInvestigator(string $id, SaveInvestigatorDTO $dto): InvestigatorDTO
  {
    $inv = $this->investigatorRepository->findInvestigatorById($id);

    if (!$inv) {
      throw new Exception('Unable to update this investigator', code: 404);
    }

    $this->setInvestigatorFromDTO($inv, $dto);

    $this->entityManager->flush();

    $updatedDTO = $this->mapper->toDTO($inv, withAvailabilities: true);

    return $updatedDTO;
  }
}
