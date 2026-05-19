<?php

namespace App\Entities;

use App\Entities\AbstractAvailability;
use App\Repositories\InvestigatorAvailabilityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvestigatorAvailabilityRepository::class)]
#[ORM\Table(name: 'investigator_availability')]
class InvestigatorAvailability extends AbstractAvailability
{
  #[ORM\ManyToOne(targetEntity: Investigator::class, inversedBy: 'availabilities')]
  private Investigator $investigator;

  public function setInvestigator(Investigator $investigator): static
  {
    $this->investigator = $investigator;
    return $this;
  }

  public function getInvestigator(): Investigator
  {
    return $this->investigator;
  }
}