<?php

namespace App\Services;

use App\DTO\AvailabilityDTO;
use App\DTO\InvestigatorDTO;
use App\DTO\SaveInvestigatorDTO;
use App\Entities\InvestigatorAvailability;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use App\Repositories\InvestigatorRepository;
use App\Entities\Investigator;
use Exception;

class InvestigatorService
{

  private InvestigatorRepository $investigatorRepository;
  private EntityManagerInterface $entityManager;

  public function __construct(InvestigatorRepository $repo, EntityManagerInterface $em)
  {
    $this->investigatorRepository = $repo;
    $this->entityManager = $em;
  }

  private function mapInvestigatorToDTO(Investigator $inv, bool $withAvailabilities = false): InvestigatorDTO
  {

    $availabilitiesDTO = [];

    if ($withAvailabilities){
      foreach ($inv->getAvailabilities() as $avail) {
        $availabilitiesDTO[] = new AvailabilityDTO(
          id: $avail->getId(),
          dayOfWeek: $avail->getDayOfWeek(),
          openTime: $avail->getOpenTime()->format('H:i'),
          closeTime: $avail->getCloseTime()->format('H:i')
        );
      }
    }

    $dto = new InvestigatorDTO(
      id: $inv->getId(),
      code: $inv->getCode(),
      lastname: $inv->getLastname(),
      firstname: $inv->getFirstname(),
      address: $inv->getAddress(),
      postalCode: $inv->getPostalCode(),
      city: $inv->getCity(),
      country: $inv->getCountry(),
      phone:$inv->getPhone(),
      lat: $inv->getLat(),
      lng: $inv->getLng(),
      createdAt: $inv->getCreatedAt()->format("c"),
      availabilities: $availabilitiesDTO
    );

    return $dto;
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
    $investigators = $this->investigatorRepository->getAllInvestigators();
    $dtos = [];

    foreach ($investigators as $inv) {
      $dtos[] = $this->mapInvestigatorToDTO($inv);
    }

    return $dtos;
  }

  public function getInvestigatorDetails(string $id): InvestigatorDTO
  {
    $investigator = $this->investigatorRepository->findInvestigatorById($id);

    if (!$investigator) {
      throw new Exception("Unable to retrieve investigator with this id", 404);
    }

    $dto = $this->mapInvestigatorToDTO($investigator, true);

    return $dto;
  }

  public function createInvestigator(SaveInvestigatorDTO $dto): InvestigatorDTO
  {

    $inv = new Investigator();
    $this->setInvestigatorFromDTO($inv, $dto);
    

    $this->entityManager->persist($inv);
    $this->entityManager->flush();

    $investigatorDTO = $this->mapInvestigatorToDTO($inv, withAvailabilities:true);

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

    $updatedDTO = $this->mapInvestigatorToDTO($inv, withAvailabilities: true);

    return $updatedDTO;
  }
}
